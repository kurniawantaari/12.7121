$(function () {
    $("#variables, #tabcol,#tabrow").sortable({
        items: "> li",
        connectWith: ".connectedVariables",
        // axis: "x" //only horizontally or vertically
        cancel: "a.ui-icon", // clicking an icon won't initiate dragging
        containment: $(".site-generateTable"),
        cursor: "move",
        //handle:".handle"
        //helper: "clone",
        // forceHelperSize: false,
        //opacity: 0.7, //opacity helper
        dropOnEmpty: true,
        placeholder: "drop-placeholder",
        forcePlaceholderSize: true,
        revert: true,
        //scroll:false
        tolerance: "pointer",
    }).disableSelection();
});