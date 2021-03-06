NodeView = OrchestraView.extend(
  events:
    'click .js-widget-blockpanel .header': 'toggle'
    'mouseover .js-widget-blockpanel li': 'addClass'
    'mouseout .js-widget-blockpanel li': 'removeClass'
    'mousedown .js-widget-blockpanel li': 'removeClass'

  extendView : [ 'commonPage', 'addArea' ]

  initialize: (options) ->
    @options = @reduceOption(options, [
      'node'
      'domContainer'
    ])
    @completeOptions @options.node,
      'multiLanguage': 'showNodeWithLanguage'
      'multiVersion': 'showNodeWithLanguageAndVersion'
      'duplicate': 'showNodeWithLanguage'
      'entityType': 'node'
    @options.configuration = @options.node
    @options.entityType = 'node'
    @options.editable = @options.node.get('editable')
    @options.redirectUrl = appRouter.generateUrl "showNode",
      nodeId: @options.configuration.get('parent_id')
    @loadTemplates [
      "OpenOrchestraBackofficeBundle:BackOffice:Underscore/nodeView"
      "OpenOrchestraBackofficeBundle:BackOffice:Underscore/blockView"
      "OpenOrchestraBackofficeBundle:BackOffice:Underscore/elementTitle"
      "OpenOrchestraBackofficeBundle:BackOffice:Underscore/blocksPanel"
    ]
    return

  render: ->
    parameters = appRouter.extractParameters()
    if parameters.length > 0  and parameters[0] == @options.node.attributes.node_id
      @setElement @renderTemplate('OpenOrchestraBackofficeBundle:BackOffice:Underscore/nodeView',
        node: @options.node
      )
      @options.domContainer.html @$el
      $('.js-widget-title', @$el).html @renderTemplate('OpenOrchestraBackofficeBundle:BackOffice:Underscore/elementTitle',
        element: @options.node
      )
      @addAreasToView(@options.node.get('areas'))
      @addPageLayoutButton()
      if !@options.editable
        $('.js-widget-blockpanel', @$el).hide()
      else
        @addListBlockToView()
    return

  addListBlockToView: ->
    viewContext = @
    $.ajax
      type: "GET"
      url: @options.node.get('links')._block_list
      success: (response) ->
        for i of response.blocks
          blockElement = new BlockModel()
          blockElement.set response.blocks[i]
          response.blocks[i] = viewContext.renderTemplate('OpenOrchestraBackofficeBundle:BackOffice:Underscore/blockView', 
            block : blockElement
          )
        blocksPanelViewClass = appConfigurationView.getConfiguration('node', 'showBlocksPanel')
        new blocksPanelViewClass(
          blocks : response.blocks
          domContainer : $('.js-widget-blockpanel', viewContext.$el))

  toggle: (event) ->
    event.preventDefault()
    $(event.currentTarget).parent().toggleClass "activate"
    $('#content .jarviswidget > div').toggleClass "panel-activate"
    $(event.currentTarget).effect "highlight", {}, 500
    makeSortable ".js-widget-blockpanel .ui-model", true if $(event.currentTarget).parent().hasClass("activate")

  addClass: (event) ->
    $(event.currentTarget).addClass "hover"
    
  removeClass: (event) ->
    $(event.currentTarget).removeClass "hover"
)
