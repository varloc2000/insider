/**
 * Global namespace
 * @required jQuery
 */
var Insider = {
    $container: $('html')
};

/**
 * leagueTable
 * @param string leagueTableId
 * @return void
 */
Insider.leagueTable = function(leagueTableId) {
    this.leagueTableId = leagueTableId;

    this.currentWeek        = $('#' + this.leagueTableId).data('week');
    this.allBtnSelector     = '.' + this.leagueTableId + '-all';
    this.switchBtnSelector  = '.' + this.leagueTableId + '-switch';
    this.prevWeekCache      = null;
    this.nextWeekCache      = null;

    this.$tableWrapper      = $('#' + this.leagueTableId + '-wrapper');
};
    Insider.leagueTable.prototype.init = function() {
        var _self = this;

        this.$tableWrapper.on('click', this.switchBtnSelector, function(e) {
            e.preventDefault();

            _self._onSwitchClick($(this));
        });
    };
    Insider.leagueTable.prototype._onSwitchClick = function($initiator) {
        if ($initiator.hasClass('disabled')) {
            return;
        }

        var _self = this,
            week = this.currentWeek;

        switch ($initiator.data('direction')) {
            case 'prev':
                week = week - 1;

                break;
            case 'next':
                week = week + 1;

                break;
            default:
                return;
        }

        $('.league-table-spinner').addClass('active');

        $.get(
            $initiator.data('href'),
            {week: week},
            function(data) {
                $('.league-table-spinner').removeClass('active');

                if (false === data.success) {
                    $initiator.addClass('disabled');

                    return;
                }

                _self.$tableWrapper.html(data.content);
                _self.currentWeek = week;
            },
            'json'
        );
    };
