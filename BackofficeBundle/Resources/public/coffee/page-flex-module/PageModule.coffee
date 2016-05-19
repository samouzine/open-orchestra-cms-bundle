###*
 * @namespace OpenOrchestra:PageModule
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
class OpenOrchestra.PageModule.OrchestraPageModule extends OpenOrchestra.Common.OrchestraModule

  ###*
   * Build Module
  ###
  build: () ->
    # Voir pour supprimer le singleton
    @container.register("page_module.view.templateFlexView", OpenOrchestra.PageModule.View.TemplateFlexView)

    @container.register("page_module.controller.templateFlexController", OpenOrchestra.PageModule.Controller.TemplateFlexController, "singleton")
    @container.get("page_module.controller.templateFlexController").setContainer(@container)

    OpenOrchestra.PageModule.Router.TemplateFlexRouter.$inject = ["page_module.controller.templateFlexController"]
    @container.register("page_module.router.templateRouter", OpenOrchestra.PageModule.Router.TemplateFlexRouter, "singleton")

  ###*
   * Start module
  ###
  start: (containerHtml) ->
    @container.get("page_module.router.templateRouter")
    containerHtml.html @container.get("page_module.view.templateFlexView").render().el
