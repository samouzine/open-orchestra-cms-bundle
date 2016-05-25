###*
 * @namespace OpenOrchestra
###
window.OpenOrchestra or= {}

###*
 * @class App
###
class OpenOrchestra.App extends Marionette.Application

  ###*
   * Constructor App
  ###
  initialize: () ->
    console.log "init"
    @appContainer = intravenous.create()

    OpenOrchestra.PageModule.OrchestraPageModule.$inject = ["container"]
    @appContainer.register("page_module", OpenOrchestra.PageModule.OrchestraPageModule, "singleton")
    @appContainer.get("page_module").build()

    # Test override service
    OpenOrchestra.PageModule.Router.TemplateFlexRouterOverride.$inject = ["page_module.controller.templateFlexController"]
    @appContainer.register("page_module.router.templateRouter", OpenOrchestra.PageModule.Router.TemplateFlexRouterOverride, "singleton")

jQuery ->
  app = new OpenOrchestra.App()
  app.on "start", () ->
    console.log 'start'
    if (Backbone.history)
      Backbone.history.start()
    @appContainer.get("page_module").start($("#content"))

  app.start()
