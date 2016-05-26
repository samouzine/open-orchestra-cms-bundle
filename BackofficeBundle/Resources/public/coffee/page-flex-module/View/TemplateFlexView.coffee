###*
 * @namespace OpenOrchestra:PageModule.View
 * @class TemplateFlexView
###
class OpenOrchestra.PageModule.View.TemplateFlexView extends OrchestraView

  ###*
   * required options
   * {
   *   template: {object}
   * }
   *
   * @param {Object} options
  ###
  initialize: (options) ->
    @options = options || {};
    @options.entityType = 'template-flex'
    @loadTemplates [
      "OpenOrchestraBackofficeBundle:BackOffice:Underscore/templateFlex/templateFlexView"
    ]
    #OpenOrchestra.AreaFlex.Channel.bind 'activateSortableArea', @showOverlaySortableArea, @
    #OpenOrchestra.AreaFlex.Channel.bind 'disableSortableArea', @hideOverlaySortableArea, @
    return

  ###*
   * Render
  ###
  render: ->
    console.log "render"
    @setElement @renderTemplate('OpenOrchestraBackofficeBundle:BackOffice:Underscore/templateFlex/templateFlexView')
    @addArea($('.template-flex-container', @$el), @options.template.get('area'))

  ###*
   * @param {Object} container Jquery selector
   * @param {Object} areas List of areas to add in container
  ###
  addArea: (container, area) ->
    areaModel = new Area
    areaModel.set area
    areaViewClass = appConfigurationView.getConfiguration(@options.entityType, 'addAreaFlex')
    new areaViewClass(
      area: areaModel
      domContainer: container
      toolbarContainer: $('.toolbar-container', @$el)
    )

  ###*
   * Add button configuration page
  ###
  ###addConfigurationButton: () ->
    pageConfigurationButtonViewClass = appConfigurationView.getConfiguration(@options.entityType, 'addConfigurationButton')
    new pageConfigurationButtonViewClass(@addOption(
      viewContainer: @
      widget_index: 2
    ))
  ###

  ###*
   * Hide overlay on area
  ###
  hideOverlaySortableArea: () ->
    if $('.overlay-sortable', @$el).length > 0
      $('.overlay-sortable', @$el).remove()

  ###*
   * Show overlay on area
  ###
  showOverlaySortableArea: () ->
    if $('.overlay-sortable', @$el).length == 0
      $('.template-flex-container',@$el).prepend($('<div/>', { 'class': 'overlay-sortable'}))
