FullPageFormView = OrchestraView.extend(
  initialize: (options) ->
    @initializer options
    @loadTemplates [
      'OpenOrchestraBackofficeBundle:BackOffice:Underscore/fullPageFormView',
      'OpenOrchestraBackofficeBundle:BackOffice:Underscore/elementTitle',
    ]
    return

  initializer: (options) ->
    @options = options
    @options.listUrl = appRouter.generateUrl('listEntities', entityType: options.entityType) if options.listUrl == undefined
    if @options.element != undefined
      @completeOptions @options.element,
        'multiLanguage': 'showEntityWithLanguageAndSourceLanguage'
        'multiVersion': 'showEntityWithLanguageAndVersion'
        'duplicate': 'showEntityWithLanguage'
    @events = @events || {}

  render: ->
    @setElement @renderTemplate('OpenOrchestraBackofficeBundle:BackOffice:Underscore/fullPageFormView', @options)
    @options.domContainer.html @$el
    $('.js-widget-title', @options.domContainer).html @options.title
    @addEventOnForm()
    $("[data-prototype]", @$el).each ->
      PO.formPrototypes.addPrototype $(this)
      return
    return

  addEventOnForm: ->
    options = @options
    $("form", @$el).on "submit", (e) ->
      e.preventDefault()
      $(this).ajaxSubmit
        context: button: $(".submit_form",e.target).parent()
        success: (response) ->
          options.html = response
          new FullPageFormView(options)
        error: (response) ->
          options.html = response.responseText
          new FullPageFormView(options)
      return
)
