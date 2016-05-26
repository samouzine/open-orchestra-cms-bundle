###*
 * @namespace OpenOrchestra:PageModule.View
 * @class TemplateFlexRouter
###
class OpenOrchestra.PageModule.Router.TemplateFlexRouter extends Marionette.AppRouter

  appRoutes: {
    'template-flex-poc/show/:templateId': 'showTemplateFlex',
  }

  ###*
   * Constructor
   *
   * @param {object} templateFlexController
  ###
  constructor: (templateFlexController) ->
    super(
      controller: templateFlexController
    )
