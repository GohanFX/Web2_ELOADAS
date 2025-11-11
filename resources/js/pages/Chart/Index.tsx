import { Head } from '@inertiajs/react';
import Layout from '@/components/Layout';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
    ArcElement,
    PointElement,
} from 'chart.js';
import { Bar, Line, Pie } from 'react-chartjs-2';

ChartJS.register(
    CategoryScale,
    LinearScale,
    BarElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
    ArcElement,
    PointElement
);

interface DriversByCountry {
    country: string;
    total: number;
}

interface RacesByYear {
    year: number;
    total: number;
}

interface TopDriver {
    id: number;
    name: string;
    results_count: number;
}

interface Props {
    driversByCountry: DriversByCountry[];
    racesByYear: RacesByYear[];
    topDrivers: TopDriver[];
}

export default function Index({ driversByCountry, racesByYear, topDrivers }: Props) {
    const countryChartData = {
        labels: driversByCountry.map(d => d.country),
        datasets: [
            {
                label: 'Pilóták száma',
                data: driversByCountry.map(d => d.total),
                backgroundColor: 'rgba(239, 68, 68, 0.5)',
                borderColor: 'rgba(239, 68, 68, 1)',
                borderWidth: 1,
            },
        ],
    };

    const yearChartData = {
        labels: racesByYear.map(r => r.year.toString()),
        datasets: [
            {
                label: 'Versenyek száma',
                data: racesByYear.map(r => r.total),
                fill: false,
                borderColor: 'rgb(59, 130, 246)',
                tension: 0.1,
            },
        ],
    };

    const topDriversChartData = {
        labels: topDrivers.map(d => d.name),
        datasets: [
            {
                label: 'Versenyek száma',
                data: topDrivers.map(d => d.results_count),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)',
                    'rgba(199, 199, 199, 0.6)',
                    'rgba(83, 102, 255, 0.6)',
                    'rgba(255, 99, 255, 0.6)',
                    'rgba(99, 255, 132, 0.6)',
                ],
            },
        ],
    };

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'top' as const,
            },
        },
    };

    return (
        <Layout>
            <Head title="Diagramok" />

            <div>
                <div className="mb-8">
                    <h1 className="text-4xl font-bold mb-2">Statisztikák és Diagramok</h1>
                    <p className="text-muted-foreground">
                        Vizualizálja a Formula 1 adatokat interaktív diagramokkal
                    </p>
                </div>

                <div className="grid gap-6">
                    <Card>
                        <CardHeader>
                            <CardTitle>Top 10 ország pilótaszám szerint</CardTitle>
                            <CardDescription>
                                A legtöbb pilótát adó országok rangsora
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="h-[400px] flex items-center justify-center">
                                <Bar data={countryChartData} options={chartOptions} />
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Versenyek évek szerint</CardTitle>
                            <CardDescription>
                                A versenyek számának alakulása az évek során
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="h-[400px] flex items-center justify-center">
                                <Line data={yearChartData} options={chartOptions} />
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Top 10 pilóta versenyeik száma szerint</CardTitle>
                            <CardDescription>
                                A legtöbb versenyen részt vett pilóták
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="h-[500px] flex items-center justify-center">
                                <Pie data={topDriversChartData} options={{
                                    ...chartOptions,
                                    plugins: {
                                        ...chartOptions.plugins,
                                        legend: {
                                            position: 'right' as const,
                                        },
                                    },
                                }} />
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </Layout>
    );
}

