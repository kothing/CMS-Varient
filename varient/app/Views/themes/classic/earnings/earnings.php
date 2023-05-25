<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= trans("earnings"); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="profile-page-top">
                    <?= loadView('profile/_profile_user_info', ['user' => user()]); ?>
                </div>
            </div>
        </div>
        <div class="profile-page">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <?= loadView('earnings/_tabs'); ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <div class="earnings-box earnings-box-pageviews">
                                <strong><?= user()->total_pageviews; ?></strong>
                                <label><?= trans("total_pageviews"); ?></label>
                                <i class="icon-chart"></i>
                            </div>
                            <div class="earnings-box earnings-box-balance">
                                <strong><?= priceFormatted(user()->balance); ?></strong>
                                <label><?= trans("balance"); ?></label>
                                <i class="icon-coin-bag"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <script src="<?= base_url('assets/js/jquery-1.12.4.min.js'); ?>"></script>
                            <script src="<?= base_url('assets/vendor/chart/chart.min.js'); ?>"></script>
                            <script src="<?= base_url('assets/vendor/chart/utils.js'); ?>"></script>
                            <script src="<?= base_url('assets/vendor/chart/analyser.js'); ?>"></script>
                            <div class="content">
                                <div style="min-height: 400px;">
                                    <canvas id="chart-2"></canvas>
                                </div>
                            </div>
                            <div class="table-responsive table-earnings">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col"><?= trans("date"); ?></th>
                                        <th scope="col"><?= trans("pageviews"); ?></th>
                                        <th scope="col"><?= trans("earnings"); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($pageViewsCounts)):
                                        for ($i = 1; $i <= $numberOfDays; $i++):
                                            if ($i <= $today):
                                                $earning = getEarningObjectByDay($i, $pageViewsCounts);
                                                if (!empty($earning)):?>
                                                    <tr>
                                                        <td><?= date("M j, Y", strtotime($earning->date)); ?></td>
                                                        <td><?= $earning->count; ?></td>
                                                        <td><?= priceFormatted($earning->total_amount, getRewardPriceDecimal()); ?></td>
                                                    </tr>
                                                <?php endif;
                                            endif;
                                        endfor;
                                    endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <script>
                                var number_of_days = parseInt('<?= $numberOfDays; ?>');
                                var presets = window.chartColors;
                                var utils = Samples.utils;
                                var inputs = {
                                    min: 0,
                                    max: 1,
                                    count: 8,
                                    decimals: 2,
                                    continuity: 1
                                };

                                function generateLabels(config) {
                                    var labels = [];
                                    var i;
                                    for (i = 1; i <= number_of_days; i++) {
                                        labels.push(i);
                                    }
                                    return labels;
                                }

                                var options = {
                                    maintainAspectRatio: false,
                                    spanGaps: false,
                                    elements: {
                                        line: {
                                            tension: 0.000001
                                        }
                                    },
                                    plugins: {
                                        filler: {
                                            propagate: false
                                        }
                                    },
                                    scales: {
                                        x: {
                                            ticks: {
                                                autoSkip: false,
                                                maxRotation: 0
                                            }
                                        },
                                        xAxes: [
                                            {
                                                scaleLabel: {
                                                    display: true,
                                                    labelString: ''
                                                }
                                            }
                                        ],
                                        yAxes: [
                                            {
                                                ticks: {
                                                    beginAtZero: true,
                                                    callback: function (label, index, labels) {
                                                        return "<?= esc($generalSettings->currency_symbol); ?>" + label.toFixed(4);
                                                    }
                                                }
                                            }
                                        ]
                                    },
                                    tooltips: {
                                        enabled: false
                                    },
                                    legend: {
                                        onClick: null
                                    }
                                };
                                [false, 'origin', 'start', 'end'].forEach(function (boundary, index) {
                                    // reset the random seed to generate the same data for all charts
                                    utils.srand(8);
                                    new Chart('chart-' + index, {
                                        type: 'line',
                                        data: {
                                            labels: generateLabels(),
                                            datasets: [{
                                                backgroundColor: utils.transparentize(presets.green),
                                                borderColor: presets.green,
                                                data: [
                                                    <?php for ($i = 1; $i <= $numberOfDays; $i++) {
                                                    if ($i <= $today) {
                                                        if ($i != 1) {
                                                            echo ',';
                                                        }
                                                        $earning = getEarningObjectByDay($i, $pageViewsCounts);
                                                        if (!empty($earning)) {
                                                            if (!empty($earning->total_amount)) {
                                                                echo number_format($earning->total_amount, getRewardPriceDecimal(), '.', '');
                                                            }
                                                        } else {
                                                            echo '0';
                                                        }
                                                    }
                                                } ?>
                                                ],
                                                label: '<?= trans("earnings") ?>: <?= replaceMonthName(date("M Y"));?>',
                                                fill: boundary
                                            }]
                                        },
                                        options: Chart.helpers.merge(options, {
                                            title: {
                                                text: 'fill: ' + boundary,
                                                display: false
                                            }
                                        })
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>