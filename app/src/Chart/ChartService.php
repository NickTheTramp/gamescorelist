<?php

namespace App\Chart;

use App\Chart\Data\ChartDataService;
use App\Entity\Game;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartService
{
    private ChartBuilderInterface $chartBuilder;
    private ChartDataService $chartDataService;

    public function __construct(
        ChartBuilderInterface $chartBuilder,
        ChartDataService      $chartDataService
    )
    {
        $this->chartBuilder = $chartBuilder;
        $this->chartDataService = $chartDataService;
    }

    public function createOverallWinrateChart(Game $game): Chart
    {
        $chart = $this->chartBuilder->createChart(Chart::TYPE_PIE);

        $data = $this->chartDataService->getOverallWinrate($game);

        $chart->setData([
            'labels' => array_keys($data),
            'datasets' => [
                [
                    'backgroundColor' => [
                        // Wins
                        'rgb(60, 179, 113)',
                        // Losses
                        'rgb(255, 0, 0)'
                    ],
                    'data' => array_values($data),
                ],
            ],
        ]);

        return $chart;
    }

    public function createWinratePerGameChart(Game $game): Chart
    {
        $chart = $this->chartBuilder->createChart(Chart::TYPE_POLAR_AREA);

        $data = $this->chartDataService->getWinratePerMap($game);

        $chart->setData([
            'labels' => array_column($data, 'game'),
            'datasets' => [
                [
                    'backgroundColor' => [
                        'rgba(51, 182, 95, 0.5)',
                        'rgba(138, 160, 69, 0.5)',
                        'rgba(231, 158, 151, 0.5)',
                        'rgba(63, 129, 68, 0.5)',
                        'rgba(87, 233, 236, 0.5)',
                        'rgba(67, 180, 217, 0.5)',
                        'rgba(226, 221, 144, 0.5)',
                        'rgba(124, 207, 132, 0.5)',
                    ],
                    'data' => array_column($data, 'winrate'),
                ],
            ],
        ]);

        $chart->setOptions([
            'scale' => [
                'ticks' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
        ]);

        return $chart;
    }
}
