<div class="row">
    <style type="text/css">
        .switch-active-label {
            color: white;
        }
    </style>
    <script type="text/javascript" src="{#$AppPath#}/js/feature/filteredSelect.js"></script>
    <div id="tabs-graphs-selection" class="large-12 columns">
        <div class="row">
            <div class="large-2 columns">
                <h4>Experiment</h4>
            </div>
            <div class="large-2 columns">
                <h4>Acquisition</h4>
            </div>
            <div class="large-2 columns">
                <h4>Quantification</h4>
            </div>
            <div class="large-2 columns">
                <h4>Analysis</h4>
            </div>
            <div class="large-2 columns">
                <h4>Condition</h4>
            </div>
            <div class="large-2 columns">
                <h4>Sample</h4>
            </div>
        </div>
    </div>
    <div class="large-12 columns">
        <form id="filters">
            <div class="large-12 columns panel">
                <div class="row">
                    <div class="large-2 columns">
                        <select id="select-assay" size="12" onclick="$('#button-draw-plot').addClass('alert');
                                $('#button-draw-plot').text('Update');"></select>
                    </div>
                    <div class="large-2 columns">
                        <select id="select-acquisition" size="12" onclick="$('#button-draw-plot').addClass('alert');
                                $('#button-draw-plot').text('Update');"></select>
                    </div>
                    <div class="large-2 columns">
                        <select id="select-quantification" size="12" onclick="$('#button-draw-plot').addClass('alert');
                                $('#button-draw-plot').text('Update');"></select>
                    </div>
                    <div class="large-2 columns">
                        <select id="select-analysis" size="12" onclick="$('#button-draw-plot').addClass('alert');
                                $('#button-draw-plot').text('Update');"></select>
                    </div>
                    <div class="large-2 columns">
                        <select id="select-biomaterial" size="12" multiple="multiple" onclick="$('#button-draw-plot').addClass('alert');
                                $('#button-draw-plot').text('Update');"></select>
                    </div>
                    <div class="large-2 columns">
                        <select id="select-sample" size="12" multiple="multiple" onclick="$('#button-draw-plot').addClass('alert');
                                $('#button-draw-plot').text('Update');"></select>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="large-1 columns">&nbsp;</div>
                    <div class="large-2 columns">    
                        <div class="switch" id="unigene-isoform-switch" onclick="$('#button-draw-plot').addClass('alert');
                                $('#button-draw-plot').text('Update');">
                            <input id="unigene-barplot-button" name="unigene-isoform-switch" type="radio">
                            <label for="unigene-barplot-button" onclick="">Unigene</label>

                            <input id="isoform-barplot-button" name="unigene-isoform-switch" type="radio">
                            <label for="isoform-barplot-button" onclick="" class="switch-active-label">Isoform</label>

                            <span></span>
                        </div>
                    </div>
                    <div class="large-2 columns">&nbsp;</div>
                    <div class="large-2 columns">
                        <div class="switch" id="barplot-heatmap-switch" onclick="$('#button-draw-plot').addClass('alert');
                                $('#button-draw-plot').text('Update');">
                            <input id="button-heatmap" name="switch-x" type="radio">
                            <label for="button-heatmap" onclick="">Heatmap</label>

                            <input id="button-barplot" name="switch-x" type="radio" checked>
                            <label for="button-barplot" onclick="" class="switch-active-label">Barplot</label>

                            <span></span>
                        </div>
                    </div>
                    <div class="large-2 columns">&nbsp;</div>
                    <div class="large-2 columns">
                        <div class="button expand" id="button-draw-plot"> Draw </div>
                    </div>
                    <div class="large-1 columns">&nbsp;</div>
                </div>
            </div>
        </form>
    </div>
    <div class="large-12 columns" id="isoform-barplot-panel" name="isoform-barplot-panel" style="display:none">
        <div class="large-12 columns panel">
            <div class="row">
                <div class="large-12 columns">
                    <div class="large-3 columns">&nbsp;</div>
                    <div class="large-2 columns">
                        <label for="isoform-barplot-groupByTissues" onclick="" style="text-align: center">Group by Tissues</label>
                        <div class="switch" id="isoform-barplot-groupByTissues">
                            <input id="isoform-barplot-groupByTissues-off" name="isoform-barplot-groupByTissues" type="radio" checked>
                            <label for="isoform-barplot-groupByTissues-off" onclick="">Off</label>

                            <input id="isoform-barplot-groupByTissues-on" name="isoform-barplot-groupByTissues" type="radio">
                            <label for="isoform-barplot-groupByTissues-on" onclick="" class="switch-active-label">On</label>

                            <span></span>
                        </div>
                    </div>
                    <div class="large-2 columns">&nbsp;</div>
                    <div class="large-2 columns">
                        <label for="isoform-barplot-transpose" onclick="" style="text-align: center">Transpose Axis</label>
                        <div class="switch medium" id="isoform-barplot-transpose">
                            <input id="isoform-barplot-transpose-off" name="isoform-barplot-transpose" type="radio" checked>
                            <label for="isoform-barplot-transpose-off" onclick="">Off</label>

                            <input id="isoform-barplot-transpose-on" name="isoform-barplot-transpose" type="radio">
                            <label for="isoform-barplot-transpose-on" onclick="" class="switch-active-label">On</label>

                            <span></span>
                        </div>
                    </div>
                    <div class="large-3 columns">&nbsp;</div>
                </div>
                <div class="large-12 columns">
                    <div style="width:100%" id="isoform-barplot-canvas-parent">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>