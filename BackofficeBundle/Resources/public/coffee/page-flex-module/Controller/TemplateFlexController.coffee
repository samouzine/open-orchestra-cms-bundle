###*
 * @namespace OpenOrchestra:PageModule.Controller
 * @class TemplateFlexController
###
class OpenOrchestra.PageModule.Controller.TemplateFlexController

  ###*
   * @param {Object} router
   * @param {Object} router
  ###
  constructor: (router, templateFlexView) ->
    @router = router
    @templateFlexView = templateFlexView

  ###*
   * Show template
   *
   * @param {string} templateId
  ###
  showTemplateFlex: (templateId) ->
    ## get Data
    ## start view
    console.log templateId
    context = @
    templateFlex = new OpenOrchestra.PageModule.Model.TemplateFlexModel({template_id: templateId})
    templateFlex.fetch(
      success: (model, response, options) ->
        context.templateFlexView.renderTemplateFlex(model)
    )
