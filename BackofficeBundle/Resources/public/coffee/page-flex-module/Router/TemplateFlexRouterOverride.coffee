###*
 * @namespace OpenOrchestra:PageModule.View
 * @class TemplateFlexRouter
###
class OpenOrchestra.PageModule.Router.TemplateFlexRouterOverride extends Backbone.Router

  routes: {
    'template-flex-poc/show/:templateId': 'showTemplateFlex',
  }

  constructor: (templateFlexController) ->
    @templateFlexController = templateFlexController

  ###*
   * Show template
   *
   * @param {string} templateId
  ###
  showTemplateFlex: (templateId) ->
    console.log "override show"
    @templateFlexController.showTemplateFlex(templateId)
