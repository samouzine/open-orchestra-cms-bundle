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
    templateFlex = new OpenOrchestra.PageModule.Model.TemplateFlexModel({template_id: templateId})
    templateFlex.fetch(
      success: (model) ->
        context.container.get("page_module.view.templateFlexView").renderTemplateFlex(model)
    )
