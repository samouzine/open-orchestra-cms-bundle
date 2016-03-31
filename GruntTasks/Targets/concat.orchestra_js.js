module.exports = {
  src: [
    //--[ MAIN ]--//
    'web/built/openorchestrabackoffice/js/orchestraLib.js',
    'web/built/openorchestrabackoffice/js/tinyMCE/tinyMceConf.js',
    'web/built/openorchestrabackoffice/js/tinyMCE/bbcode2htmlConfigurator.js',
    'web/built/openorchestrabackoffice/js/tinyMCE/html2bbcodeConfigurator.js',
    'web/built/openorchestrabackoffice/js/tinyMCE/loadHtml2bbcodeInternalLink.js',
    'web/built/openorchestrabackoffice/js/viewConfigurator.js',
    'web/built/openorchestrabackoffice/js/setUpCallAjax.js',
    'web/built/openorchestrabackoffice/js/OrchestraView.js',
    'web/built/openorchestrabackoffice/js/OrchestraModalView.js',
    'web/built/openorchestrabackoffice/js/addPrototype.js',
    'web/built/openorchestrabackoffice/js/modelBackbone.js',
    'web/built/openorchestrabackoffice/js/FullPageFormView.js',
    'web/built/openorchestrabackoffice/js/ContentTypeFormView.js',
    'web/built/openorchestrabackoffice/js/FullPagePanelView.js',
    'web/built/openorchestrabackoffice/js/createNew.js',
    'web/built/openorchestrabackoffice/js/page/BlocksPanelView.js',
    'web/built/openorchestrabackoffice/js/security.js',
    'web/built/openorchestrabackoffice/js/SmartConfirmView.js',
    'web/built/openorchestrabackoffice/js/AdminFormView.js',
    'web/built/openorchestrabackoffice/js/FlashBagView.js',
    'web/built/openorchestrabackoffice/js/DisplayApiErrorView.js',
    'web/built/openorchestrabackoffice/js/generateId.js',

    //--[ AJAX LOADER ]--//
    'web/built/openorchestrabackoffice/js/ajaxLoader/AjaxLoaderView.js',

    //--[ BACKBONE ROUTER ]--//
    'web/built/openorchestrabackoffice/js/backboneRouter.js',
    'web/built/openorchestrabackoffice/js/page/LoadNodeConfigurationRoute.js',
    'web/built/openorchestrabackoffice/js/page/LoadTemplateConfigurationRoute.js',
    'web/built/openorchestrabackoffice/js/table/LoadTableConfigurationRoute.js',
    'web/built/openorchestrabackoffice/js/dashboard/LoadDashboardConfigurationRoute.js',
    'web/built/openorchestrabackoffice/js/underscoreTemplateLoader.js',

    //--[ EXTEND VIEWS ]--//
    'web/built/openorchestrabackoffice/js/extendView/addArea.js',
    'web/built/openorchestrabackoffice/js/extendView/commonPage.js',
    'web/built/openorchestrabackoffice/js/extendView/generateId.js',
    'web/built/openorchestrabackoffice/js/extendView/showVideo.js',
    'web/built/openorchestrabackoffice/js/extendView/deleteTree.js',
    'web/built/openorchestrabackoffice/js/extendView/submitAdmin.js',
    'web/built/openorchestrabackoffice/js/extendView/contentTypeSelector.js',

    //--[ WIDGETS ]--//
    'web/built/openorchestrabackoffice/js/widget/widgetChannel.js',
    'web/built/openorchestrabackoffice/js/widget/duplicateChannel.js',
    'web/built/openorchestrabackoffice/js/widget/DuplicateView.js',
    'web/built/openorchestrabackoffice/js/widget/languageChannel.js',
    'web/built/openorchestrabackoffice/js/widget/LanguageView.js',
    'web/built/openorchestrabackoffice/js/widget/previewLinkChannel.js',
    'web/built/openorchestrabackoffice/js/widget/PreviewLinkView.js',
    'web/built/openorchestrabackoffice/js/widget/statusChannel.js',
    'web/built/openorchestrabackoffice/js/widget/StatusView.js',
    'web/built/openorchestrabackoffice/js/widget/versionChannel.js',
    'web/built/openorchestrabackoffice/js/widget/VersionSelectView.js',
    'web/built/openorchestrabackoffice/js/widget/VersionView.js',

    //--[ DASHBOARD ]--//
    'web/built/openorchestrabackoffice/js/dashboard/DashboardView.js',
    'web/built/openorchestrabackoffice/js/dashboard/widget/abstract/AbstractWidgetListView.js',
    'web/built/openorchestrabackoffice/js/dashboard/widget/abstract/AbstractWidgetNodeListView.js',
    'web/built/openorchestrabackoffice/js/dashboard/widget/abstract/AbstractWidgetContentListView.js',
    'web/built/openorchestrabackoffice/js/dashboard/widget/LastNodesView.js',
    'web/built/openorchestrabackoffice/js/dashboard/widget/DraftNodesView.js',
    'web/built/openorchestrabackoffice/js/dashboard/widget/LastContentsView.js',
    'web/built/openorchestrabackoffice/js/dashboard/widget/DraftContentsView.js',

    //--[ PAGE ]--//
    'web/built/openorchestrabackoffice/js/page/makeSortable.js',
    'web/built/openorchestrabackoffice/js/page/AreaView.js',
    'web/built/openorchestrabackoffice/js/page/GSAreaView.js',
    'web/built/openorchestrabackoffice/js/page/BlockView.js',
    'web/built/openorchestrabackoffice/js/page/NodeView.js',
    'web/built/openorchestrabackoffice/js/page/NodeFormView.js',
    'web/built/openorchestrabackoffice/js/page/TemplateView.js',
    'web/built/openorchestrabackoffice/js/page/GSTemplateView.js',
    'web/built/openorchestrabackoffice/js/page/TemplateFormView.js',
    'web/built/openorchestrabackoffice/js/page/SubElementFormView.js',
    'web/built/openorchestrabackoffice/js/page/showNode.js',
    'web/built/openorchestrabackoffice/js/page/showTemplate.js',
    'web/built/openorchestrabackoffice/js/page/orderNode.js',
    'web/built/openorchestrabackoffice/js/page/PageConfigurationButtonView.js',
    'web/built/openorchestrabackoffice/js/page/viewportChannel.js',
    'web/built/openorchestrabackoffice/js/page/FieldOptionDefaultValueView.js',

    //--[ AREA FLEX ]--//
    'web/built/openorchestrabackoffice/js/areaFlex/AreaFlexChannel.js',
    'web/built/openorchestrabackoffice/js/areaFlex/AreaFlexAddRowExtendView.js',
    'web/built/openorchestrabackoffice/js/areaFlex/AreaFlexFormView.js',
    'web/built/openorchestrabackoffice/js/areaFlex/AreaFlexFormRowView.js',
    'web/built/openorchestrabackoffice/js/areaFlex/AreaFlexView.js',
    'web/built/openorchestrabackoffice/js/areaFlex/AreaFlexToolbarView.js',

    //--[ TEMPLATE FLEX ]--//
      'web/built/openorchestrabackoffice/js/templateFlex/TemplateFlexFormView.js',
      'web/built/openorchestrabackoffice/js/templateFlex/TemplateFlexView.js',
      'web/built/openorchestrabackoffice/js/templateFlex/TemplateFlexRouter.js',

    //--[ TAB ]--//
    'web/built/openorchestrabackoffice/js/tab/TabView.js',
    'web/built/openorchestrabackoffice/js/tab/TabElementFormView.js',
    'web/built/openorchestrabackoffice/js/tab/tabViewFormLoader.js',

    //--[ DATATABLE ]--//
    'web/built/openorchestrabackoffice/js/dataTable/plugins/InputFullPagination.js',
    'web/built/openorchestrabackoffice/js/dataTable/header/searchField/*.js',
    'web/built/openorchestrabackoffice/js/dataTable/header/*.js',
    'web/built/openorchestrabackoffice/js/dataTable/*.js',

    //--[ TABLEVIEW ]--//
    'web/built/openorchestrabackoffice/js/table/TableOrchestraPagination.js',
    'web/built/openorchestrabackoffice/js/table/TableChannel.js',
    'web/built/openorchestrabackoffice/js/table/TableviewAction.js',
    'web/built/openorchestrabackoffice/js/table/TableviewRestoreAction.js',
    'web/built/openorchestrabackoffice/js/table/TableviewCollectionView.js',
    'web/built/openorchestrabackoffice/js/table/tableviewLoader.js',

    //--[ USER ]--//
    'web/built/openorchestrabackoffice/js/user/UserFormView.js',
    'web/built/openorchestrauseradmin/js/user/*.js',

    //--[ CONTENT TYPE ]--//
    'web/built/openorchestrabackoffice/js/contentType/TableviewCollectionView.js',

    //--[ WEBSITE ]--//
    'web/built/openorchestrabackoffice/js/webSite/WebSiteFormView.js',

    //--[ GROUP TREE ]--//
    'web/built/openorchestrabackoffice/js/groupTree/*.js',

    //--[ INTERNAL LINK ]--//
    'web/built/openorchestrabackoffice/js/InternalLinkFormView.js',
    
    //--[ BUTTON RIBBON ]--//
    'web/built/openorchestrabackoffice/js/ribbonButton/RibbonFormButtonView.js',

    //--[ FORM BEHAVIOR ]--//
    'web/built/openorchestrabackoffice/js/formBehavior/AbstractFormBehavior.js',
    'web/built/openorchestrabackoffice/js/formBehavior/FormLibraryBehavior.js',
    'web/built/openorchestrabackoffice/js/formBehavior/ColorPicker.js',
    'web/built/openorchestrabackoffice/js/formBehavior/DatePicker.js',
    'web/built/openorchestrabackoffice/js/formBehavior/HelpText.js',
    'web/built/openorchestrabackoffice/js/formBehavior/NodeChoice.js',
    'web/built/openorchestrabackoffice/js/formBehavior/RefreshForm.js',
    'web/built/openorchestrabackoffice/js/formBehavior/RichText.js',
    'web/built/openorchestrabackoffice/js/formBehavior/TagCondition.js',
    'web/built/openorchestrabackoffice/js/formBehavior/TagCreator.js',
    'web/built/openorchestrabackoffice/js/formBehavior/ValidateHidden.js',
    
  ],
  dest: 'web/built/orchestra.js'
};
