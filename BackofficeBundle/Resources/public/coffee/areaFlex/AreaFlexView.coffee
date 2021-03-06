###*
 * @namespace OpenOrchestra:AreaFlex
###
window.OpenOrchestra or= {}
window.OpenOrchestra.AreaFlex or= {}

###*
 * @class AreaFlexView
###
class OpenOrchestra.AreaFlex.AreaFlexView extends OrchestraView

  extendView: ['OpenOrchestra.AreaFlex.AddRow']

  events:
    'click': 'triggerEditArea'
    'click .add-row': 'showFormAddRow'
    'sortstop .area-container': 'stopSortArea'

  ###*
   * @param {Object} options
  ###
  initialize: (options) ->
    @options = @reduceOption(options, [
      'area'
      'parentAreaView'
      'domContainer'
      'toolbarContainer'
    ])
    @loadTemplates [
      "OpenOrchestraBackofficeBundle:BackOffice:Underscore/areaFlex/areaFlexView"
    ]
    @options.entityType = 'area-flex'
    OpenOrchestra.AreaFlex.Channel.bind 'activateEditArea', @activateEditArea, @
    OpenOrchestra.AreaFlex.Channel.bind 'activateSortableArea', @activateSortableArea, @
    return

  ###*
   * Render area
  ###
  render: ->
    @setElement @renderTemplate('OpenOrchestraBackofficeBundle:BackOffice:Underscore/areaFlex/areaFlexView', @options)
    @options.domContainer.append @$el
    @setFlexWidth(@$el, @options.area.get('width')) if @options.area.get('width')
    @addSubAreas($('.area-container', @$el), @options.area.get('areas'))

  ###*
   * Set width in flex property if width is a number else if flex-basis property
   *
   * @param {object} area jquery element
   * @param {string} width
  ###
  setFlexWidth: (area, width) ->
    if width.match /^[0-9]+$|^auto$/g
      area.css('flex', width)
    else
      area.css('flex-basis', width)
      area.css('flex-shrink', 1)

  ###*
   * activate sortable in area
   *
   * @param {string} containerAreaId
   * @param {object} areaViewSortable
  ###
  activateSortableArea: (containerAreaId, areaViewSortable) ->
    @destroySortable()
    if containerAreaId == @options.area.get('area_id')
      sortableContainer = @$el.children('.area-container')
      sortableContainer.children().addClass('blocked')
      areaViewSortable.$el.removeClass('blocked')
      sortableContainer.sortable({
        cursor: 'move'
        tolerance: 'pointer'
        cancel: '.blocked'
      })

  ###*
   * activate sortable in area
   *
   * @param {string} rowContainerAreaId
   * @param {object} rowAreaView
  ###
  activateSortableAreaColumn: (rowContainerAreaId, columnAreaView) ->
    if rowContainerAreaId == @options.area.get('area_id')
      sortableContainer = @$el.children('.area-container')
      sortableContainer.children().addClass('blocked')
      columnAreaView.$el.removeClass('blocked')
      sortableContainer.sortable({
        cancel: '.blocked'
      })

  ###*
   * Stop sortable area
  ###
  stopSortArea: (event)->
    event.stopPropagation()
    @destroySortable()
    @updateOrderChildrenAreas()

  ###*
   * Destroy sortable area
  ###
  destroySortable: () ->
    if @$el.children('.area-container').hasClass('ui-sortable')
      @$el.children('.area-container').sortable('destroy')
    OpenOrchestra.AreaFlex.Channel.trigger 'disableSortableArea'
    @$el.children('.area-container').children().removeClass('blocked')
    @$el.children('.area-container').children().css('z-index', '')

  ###*
   * Update order children areas
  ###
  updateOrderChildrenAreas: () ->
    data = {}
    data.area_id = @options.area.get('area_id')
    data.areas = []
    for area in @options.area.get('areas')
      subArea = {}
      subArea.area_id = area.area_id
      subArea.order = $('.area-flex[data-area-id="'+area.area_id+'"]', @$el).index()
      data.areas.push(subArea)
    url = @options.area.get('links')._self_move_area
    if url?
      $.ajax
         url: url
         method: 'POST'
         data: JSON.stringify(data)

  ###*
   * Add sub areas
   *
   * @param {object} container jquery element
   * @param {object} areas
  ###
  addSubAreas: (container, areas) ->
    for area in areas
      areaModel = new Area
      areaModel.set area
      areaViewClass = appConfigurationView.getConfiguration(@options.entityType, 'addAreaFlex')
      new areaViewClass(
        area: areaModel
        parentAreaView: @
        domContainer: container
        toolbarContainer: @options.toolbarContainer
      )

  ###*
   * Triggers an event to activate the edition of area
  ###
  triggerEditArea: (event) ->
    event.stopPropagation()
    if (@options.area.get('area_type') != 'row')
      OpenOrchestra.AreaFlex.Channel.trigger 'activateEditArea', @options.area.get('area_id')

  ###*
    * @param {string} areaId
  ###
  activateEditArea: (areaId) ->
    if areaId == @options.area.get('area_id')
      @$el.children('.area-action').show()
      @$el.addClass('active')
      viewClass = appConfigurationView.getConfiguration(@options.entityType, 'showAreaFlexToolbar')
      new viewClass(
        area: @options.area
        areaView: @
        domContainer: @options.toolbarContainer
      )
    else
      @$el.children('.area-action').hide()
      @$el.removeClass('active')
