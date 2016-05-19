###*
 * @namespace OpenOrchestra
###
window.OpenOrchestra or= {}

###*
 * @class App
###
class OpenOrchestra.App

  ###*
   * Constructor App
  ###
  constructor: () ->
    @appContainer = intravenous.create()

    OpenOrchestra.PageModule.OrchestraPageModule.$inject = ["container"]
    @appContainer.register("page_module", OpenOrchestra.PageModule.OrchestraPageModule, "singleton")
    @appContainer.get("page_module").build()

    # Test override service
    OpenOrchestra.PageModule.Router.TemplateFlexRouterOverride.$inject = ["page_module.controller.templateFlexController"]
    @appContainer.register("page_module.router.templateRouter", OpenOrchestra.PageModule.Router.TemplateFlexRouterOverride, "singleton")

  ###*
   * Start application
  ###
  start: () ->
    @appContainer.get("page_module").start($("#content"))


jQuery ->
  app = new OpenOrchestra.App()
  app.start()
  Backbone.history.start()
  return
