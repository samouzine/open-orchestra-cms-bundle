###*
 * @namespace OpenOrchestra:PageModule.View
 * @class TemplateFlexRouterOverride
###
class OpenOrchestra.PageModule.Router.TemplateFlexRouterOverride extends Backbone.Router

  routes: {
    'template-flex-poc/show/:templateId': 'showTemplateFlex',
  }

  initialize: (templateFlexController) ->
    @templateFlexController = templateFlexController

  ###*
   * Show template
   *
   * @param {string} templateId
  ###
  showTemplateFlex: (templateId) ->
    console.log "override show"
    @templateFlexController.showTemplateFlex(templateId)
