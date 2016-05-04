###*
 * @namespace OpenOrchestra
###
window.OpenOrchestra or= {}

###*
 * @class App
###
class OpenOrchestra.App

  ###*
   * @param {Object} options
  ###
  constructor: (@options) ->
    console.log "init app"

  ###*
   * Start application
  ###
  start: () ->
    new OpenOrchestra.PageModule.OrchestraPageModule({
      container: $("#content")
    }).start()

jQuery ->
  console.log "init"
  if window.location.pathname.indexOf('login') == -1
    app = new OpenOrchestra.App()
    app.start()
    Backbone.history.start()
  return
