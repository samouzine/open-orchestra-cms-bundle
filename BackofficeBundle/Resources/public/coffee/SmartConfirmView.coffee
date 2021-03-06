SmartConfirmView = OrchestraView.extend(

  initialize: (options) ->
    @options = options
    @loadTemplates [
      "OpenOrchestraBackofficeBundle:BackOffice:Underscore/smartConfirmButton"
      "OpenOrchestraBackofficeBundle:BackOffice:Underscore/smartConfirmTitle"
    ]
    return

  render: ->
    options = @options
    buttons = [];
    for i of options.buttons
      options.buttons[i].html = @renderTemplate('OpenOrchestraBackofficeBundle:BackOffice:Underscore/smartConfirmButton', confirm:  options.buttons[i].text)
      buttons.unshift options.buttons[i].html
    title = @renderTemplate('OpenOrchestraBackofficeBundle:BackOffice:Underscore/smartConfirmTitle',
      titleColorized: options.titleColorized
      logo: options.logo
    )
    $.SmartMessageBox
      title: title
      content: options.text
      buttons:  "[" + buttons.join("][") + "]"
    , (ButtonPressed) ->
        for i of options.buttons
          options.buttons[i].callBack(options.callBackParams) if options.buttons[i].html.match(ButtonPressed) != null
        return
    return
)
