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

  ###*
   * Start application
  ###
  start: () ->
    OpenOrchestra.PageModule.OrchestraPageModule.$inject = ["container"]
    @appContainer.register("page_module", OpenOrchestra.PageModule.OrchestraPageModule, "singleton")
    @appContainer.get("page_module", {containerHtml : $("#content") }).start()

    # Test override service
    #OpenOrchestra.PageModule.Router.TemplateFlexRouterOverride.$inject = ["page_module.controller.templateFlexController"]
    #@appContainer.get("page_module").getContainer().register("page_module.router.templateRouter", OpenOrchestra.PageModule.Router.TemplateFlexRouterOverride, "singleton")

jQuery ->
  console.log "init"
  app = new OpenOrchestra.App()
  app.start()
  Backbone.history.start()
  console.log Backbone.history
  return
