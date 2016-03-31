###*
 * @namespace OpenOrchestra:TemplateFlex
###
window.OpenOrchestra or= {}
window.OpenOrchestra.RibbonButton or= {}

###*
 * @class RibbonFormButtonView
###
class OpenOrchestra.RibbonButton.RibbonFormButtonView extends OrchestraView


  ###*
   * set focused view
  ###
  setFocusedView: (view, container) ->
    @container = if typeof container == 'undefined' then $('.ribbon-form-button') else container
    @container.html('')
    viewContext = this
    $('.btn-in-ribbon', view.$el).each ->
      viewContext.cloneButton $(this)
      return
    return

  ###*$
   * Method call to clone and move button
  ###
  cloneButton: (button) ->
    clonedButton = button.clone().attr('data-clone', button.attr('id')).removeAttr('id')
    button.hide()
    @container.append(clonedButton)

jQuery ->
  appConfigurationView.setConfiguration('ribbon-form-button', 'createRibbonFormButton', OpenOrchestra.RibbonButton.RibbonFormButtonView)
  ribbonFormButtonViewClass = appConfigurationView.getConfiguration('ribbon-form-button', 'createRibbonFormButton')
  window.ribbonFormButtonView = new ribbonFormButtonViewClass()
