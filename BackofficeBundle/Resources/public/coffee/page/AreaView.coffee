AreaView = OrchestraView.extend(
  extendView : [ 'addArea' ]

  events:
    'click span.area-param': 'paramArea'
    'click span.area-remove': 'confirmRemoveArea'
    'sortupdate ul.ui-model-blocks': 'moveBlock'

  initialize: (options) ->
    @options = @reduceOption(options, [
      'area'
      'configuration'
      'editable'
      'domContainer'
    ])
    @loadTemplates [
      "OpenOrchestraBackofficeBundle:BackOffice:Underscore/areaView"
    ]
    return

  render: ->
    @setElement @renderTemplate('OpenOrchestraBackofficeBundle:BackOffice:Underscore/areaView', @options)
    @options.domContainer.append @$el
    @subAreas = @$el.find('ul.ui-model-areas').first()
    @subBlocks = @$el.find('ul.ui-model-blocks').first()
    @drawContent()

  drawContent: ->
    if @options.area.get("areas").length == 0
      @$el.addClass('area-leaf')
    else
      @addAreasToView @options.area.get("areas")
    for block of @options.area.get("blocks")
      @addBlockToView @options.area.get("blocks")[block]
    refreshUl @subBlocks
    if @subAreas.children().length is 0
      @subAreas.remove()
      @subBlocks.addClass('bo-column') if @subBlocks.children().length is 0
      makeSortable @el
    else
      @subBlocks.remove()
    return

  purgeContent: ->
    @subAreas.empty()
    @subBlocks.empty()

  paramArea: (event) ->
    event.stopImmediatePropagation()
    label = "~no label yet~"
    label = @options.area.get("label")  if @options.area.get("label") isnt undefined
    adminFormViewClass = appConfigurationView.getConfiguration('area', 'showAdminForm')
    new adminFormViewClass(
      url: @options.area.get("links")._self_form
      title: "Area : " + label
      entityType: 'area'
    )
    return

  addBlockToView: (block) ->
    blockElement = new BlockModel()
    blockElement.set block
    blockViewClass = appConfigurationView.getConfiguration('area', 'addBlock')
    new blockViewClass(@addOption(
      block: blockElement
      domContainer: @subBlocks
      viewContainer: @
    ))
    @subBlocks.addClass (if @options.area.get("bo_direction") is "h" then "bo-row" else "bo-column")

# #############################################################################

  moveBlock: (event, ui) ->
    event.stopPropagation()
    areaFrom = $(event.currentTarget)
    areaTo = $(ui.item.context).parent()

    if (areaTo.find('.newly-inserted').length)
      @addBlockToArea areaTo
      return

    console.log ui.sender
    if (ui.sender)
      @moveBlockToNewArea ui.sender, areaTo
    else if (areaFrom[0] == areaTo[0])
      @moveBlockInSameArea areaFrom

  addBlockToArea: (area) ->
    currentView = @
    @updateArea area, ->
      currentView.refresh()

  removeBlockFromArea: (area) ->
    @updateArea area

  moveBlockToNewArea: (areaFrom, areaTo) ->
    # passer par une action dédiée puis supprimer les callbacks useless
    alert('move into different area')
    viewContext = @
    @updateArea areaTo, ->
      viewContext.updateArea areaFrom

  moveBlockInSameArea: (area) ->
    @updateArea area

  updateArea: (area, callback) ->
    refreshUl area
    $.ajax
      url: @options.area.get('links')._self_block
      method: 'POST'
      data: JSON.stringify
        blocks: @formatBlocks area.children()
      success: (response) ->
        callback() if callback

  formatBlocks: (blocks) ->
    blockData = []
    for block in blocks
      info = $('div[data-block-type]', block)
      if info.length > 0
        if info.data('node-id') != '' && info.data('block-id') != ''
          blockData.push
            'node_id': info.data('node-id')
            'block_id': info.data('block-id')
        else
          blockData.push
            'component': info.data('block-type')
    blockData

# ################################################################################

  refresh: ->
    currentView = @
    $.ajax
      url: @options.area.get('links')._self
      method: 'GET'
      success: (response) ->
        currentView.options.area.set(response)
        currentView.purgeContent()
        currentView.drawContent()
        refreshUl(currentView.subBlocks)

  confirmRemoveArea: (event) ->
    event.stopImmediatePropagation()
    smartConfirm(
      'fa-trash-o',
      @$el.data('delete-confirm-question'),
      @$el.data('delete-confirm-explanation'),
      callBackParams:
        areaView: @
        message: @$el.data('delete-error-txt')
      yesCallback: (params) ->
        params.areaView.$el.remove()
        refreshUl params.areaView.options.domContainer
        $.ajax
          url: params.areaView.options.area.get("links")._self_delete
          method: "DELETE"
          message: params.message
        return
    )
)
