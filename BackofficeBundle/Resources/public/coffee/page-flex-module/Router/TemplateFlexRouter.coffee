###*
 * @namespace OpenOrchestra:PageModule.View
 * @class TemplateFlexRouter
###
class OpenOrchestra.PageModule.Router.TemplateFlexRouter extends Backbone.Router

  routes: {
    'template-flex-poc/show/:templateId': 'showTemplateFlex',
  }

  initialize: (templateFlexController) ->
    console.log "base router"
    console.log templateFlexController
    @templateFlexController = templateFlexController

  ###*
   * Show template
   *
   * @param {string} templateId
  ###
  showTemplateFlex: (templateId) ->
    @templateFlexController.showTemplateFlex(templateId)
