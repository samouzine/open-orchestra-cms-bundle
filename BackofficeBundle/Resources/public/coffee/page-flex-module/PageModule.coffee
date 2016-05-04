###*
 * @namespace OpenOrchestra:TemplateFlex
###
window.OpenOrchestra or= {}
window.OpenOrchestra.PageModule = {
  Controller: {}
  Collection: {}
  Model: {}
  View: {}
  Router: {}
}

###*
 * @class PageModule
###
class OpenOrchestra.PageModule.OrchestraPageModule

  ###*
   * @param {Object} options
  ###
  constructor: (@options) ->

    @templateRouter = new OpenOrchestra.PageModule.Router.TemplateFlexRouter()
    @templateFlexView = new OpenOrchestra.PageModule.View.TemplateFlexView()

    @templateFlexController = new OpenOrchestra.PageModule.Controller.TemplateFlexController(
      @templateRouter,
      @templateFlexView
    )

    @templateRouter.setController(@templateFlexController)

  ###*
   * Start module
  ###
  start: () ->
    @options.container.html @templateFlexView.render().el





