###*
 * @namespace OpenOrchestra.Common
###
window.OpenOrchestra or= {}
window.OpenOrchestra.Common or= {}

###*
 * @class OrchestraController
###
class OpenOrchestra.Common.OrchestraController extends Marionette.Controller

  ###*
   * @param {Object} container
  ###
  setContainer : (container) ->
    @container = container
