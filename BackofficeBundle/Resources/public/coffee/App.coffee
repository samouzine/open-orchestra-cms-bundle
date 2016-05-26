###*
 * @namespace OpenOrchestra
###
window.OpenOrchestra or= {}

###*
 * @class App
###
class OpenOrchestra.App extends Marionette.Application

  ###*
   * initialize App
  ###
  initialize: () ->
    @container = intravenous.create()
    @container.register("region.contentRegion", OpenOrchestra.Regions.ContentRegion, "singleton")
    @addRegions(
      ContentRegion: @container.get("region.contentRegion")
    )

    @module("PageModule", OpenOrchestra.PageModule.OrchestraPageModule)

  ###*
   * Application start
  ###
  onStart: () ->
    @module("PageModule").start()
    if (Backbone.history)
      Backbone.history.start()

jQuery ->
  app = new OpenOrchestra.App()
  app.start()
