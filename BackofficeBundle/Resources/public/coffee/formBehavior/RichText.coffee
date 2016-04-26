###*
 * @namespace OpenOrchestra:FormBehavior
###
window.OpenOrchestra or= {}
window.OpenOrchestra.FormBehavior or= {}

###*
 * @class RichText
###
class OpenOrchestra.FormBehavior.RichText extends OpenOrchestra.FormBehavior.AbstractFormBehavior

  ###*
   * activateBehaviorOnElements
   * @param {Array} elements
   * @param {Object} view
   * @param {Object} form
  ###
  activateBehaviorOnElements: (elements, view, form) ->
    tinymce.editors = []
    $.ajax
      url: $("#contextual-informations").data("translation-url-pattern").replace("*domain*", "tinymce")
      success: (response) ->
        tinymce.util.I18n.add response.locale, response.catalog

    do (view, elements) ->
      elements.filter('[required="required"]').data('required', true)

      window.callback_tinymce_init = (editor) ->
        elements.each ->
          if $(this).data('required')
            $(this).attr('required', 'required')
        elements.addClass('focusable')
        doCallBack(editor, view)
        return
      return

    if elements.attr('disabled') == 'disabled'
      initTinyMCE($.extend(true, {}, stfalcon_tinymce_config, {theme: {simple: {readonly: 1}}}))
    else
      initTinyMCE()

    $.each(tinymce.editors, (key, editor) ->
        editor.on 'change', (event) ->
          @.save();
    )

jQuery ->
  OpenOrchestra.FormBehavior.formBehaviorLibrary.add(new OpenOrchestra.FormBehavior.RichText("textarea.tinymce"))
