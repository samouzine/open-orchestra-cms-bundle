###*
 * @namespace OpenOrchestra:PageModule.Controller
 * @class TemplateFlexController
###
class OpenOrchestra.PageModule.Controller.TemplateFlexController extends OpenOrchestra.Common.OrchestraController

  ###*
   * Show template
   *
   * @param {string} templateId
  ###
  showTemplateFlex: (templateId) ->
    context = @
    templateFlex = @container.get("page_module.model.templateFlexModel",{template_id: templateId})
    templateFlex.fetch(
      success: (model) ->
        templateFlexView = context.container.get("page_module.view.templateFlexView", {template: model})
        context.container.get("region.contentRegion").show(templateFlexView)
      error: () ->
        context.container.get("region.contentRegion").reset()
    )
