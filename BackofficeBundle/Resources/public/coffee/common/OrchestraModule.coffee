###*
 * @namespace OpenOrchestra.Common
###
window.OpenOrchestra or= {}
window.OpenOrchestra.Common or= {}

###*
 * @class OrchestraModule
###
class OpenOrchestra.Common.OrchestraModule

  ###*
  * Init container
  *
  * @param {object] AppContainer
  ###
  constructor: (AppContainer, parameters) ->
    @container = AppContainer.create();
    @parameters = parameters
    @build()

  ###*
  * @return {object] AppContainer
  ###
  getContainer: () ->
      return @container
