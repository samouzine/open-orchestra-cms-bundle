BlockView = OrchestraView.extend(
  initialize: (options) ->
    @events = {}
    @events['click div.block-param-' + @cid] = 'paramBlock'
    @block = options.block
    @areaCid = options.areaCid
    @displayClass = options.displayClass
    _.bindAll this, "render"
    @loadTemplates [
        "blockView"
    ]
    return

  paramBlock: (event) ->
    $('.modal-title').text 'Please wait ...'
    view = new adminFormView(url: @block.get('links')._self_form)

  render: ->
    $(@el).append @renderTemplate('blockView',
      block: @block
      cid: @cid
      areaCid: @areaCid
      displayClass: @displayClass
    )
    this
)
