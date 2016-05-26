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
class OpenOrchestra.PageModule.OrchestraPageModule extends Marionette.Module

  startWithParent: false

  ###*
  * @param {string} moduleName
  * @param {object} app
  * @param {object} options
  ###
  initialize: (moduleName, app, options) ->
    app.container.register("page_module.view.templateFlexView", OpenOrchestra.PageModule.View.TemplateFlexView)
    app.container.register("page_module.model.templateFlexModel", OpenOrchestra.PageModule.Model.TemplateFlexModel)

    app.container.register("page_module.controller.templateFlexController", OpenOrchestra.PageModule.Controller.TemplateFlexController, "singleton")
    app.container.get("page_module.controller.templateFlexController").setContainer(app.container)

    OpenOrchestra.PageModule.Router.TemplateFlexRouter.$inject = ["page_module.controller.templateFlexController"]
    app.container.register("page_module.router.templateRouter", OpenOrchestra.PageModule.Router.TemplateFlexRouter, "singleton")
    app.container.get("page_module.router.templateRouter")
