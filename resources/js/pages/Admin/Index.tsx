import { Head, Link } from '@inertiajs/react';
import Layout from '@/components/Layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Users, Calendar, Trophy, MessageSquare, Database } from 'lucide-react';

interface Stats {
    total_drivers: number;
    total_races: number;
    total_gps: number;
    total_contacts: number;
}

interface Props {
    stats: Stats;
}

export default function Index({ stats }: Props) {
    const statCards = [
        {
            title: 'Összes pilóta',
            value: stats.total_drivers,
            icon: Users,
            color: 'text-blue-600',
            bgColor: 'bg-blue-50',
        },
        {
            title: 'Összes verseny',
            value: stats.total_races,
            icon: Trophy,
            color: 'text-green-600',
            bgColor: 'bg-green-50',
        },
        {
            title: 'Grand Prix-k',
            value: stats.total_gps,
            icon: Calendar,
            color: 'text-purple-600',
            bgColor: 'bg-purple-50',
        },
        {
            title: 'Üzenetek',
            value: stats.total_contacts,
            icon: MessageSquare,
            color: 'text-orange-600',
            bgColor: 'bg-orange-50',
        },
    ];

    return (
        <Layout>
            <Head title="Admin Dashboard" />

            <div>
                <div className="mb-8">
                    <h1 className="text-4xl font-bold mb-2">Admin Dashboard</h1>
                    <p className="text-muted-foreground">
                        Rendszerstatisztikák és adminisztrációs funkciók
                    </p>
                </div>

                {/* Statistics Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    {statCards.map((stat) => (
                        <Card key={stat.title}>
                            <CardHeader className="flex flex-row items-center justify-between pb-2">
                                <CardTitle className="text-sm font-medium text-muted-foreground">
                                    {stat.title}
                                </CardTitle>
                                <div className={`p-2 rounded-lg ${stat.bgColor}`}>
                                    <stat.icon className={`h-4 w-4 ${stat.color}`} />
                                </div>
                            </CardHeader>
                            <CardContent>
                                <div className="text-3xl font-bold">{stat.value}</div>
                            </CardContent>
                        </Card>
                    ))}
                </div>

                {/* Quick Actions */}
                <Card className="mb-8">
                    <CardHeader>
                        <CardTitle>Gyors műveletek</CardTitle>
                        <CardDescription>
                            Gyakran használt adminisztrációs funkciók
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <Link href="/drivers">
                                <Button className="w-full" variant="outline">
                                    <Database className="mr-2 h-4 w-4" />
                                    Pilóták kezelése (CRUD)
                                </Button>
                            </Link>
                            <Link href="/messages">
                                <Button className="w-full" variant="outline">
                                    <MessageSquare className="mr-2 h-4 w-4" />
                                    Üzenetek megtekintése
                                </Button>
                            </Link>
                            <Link href="/database">
                                <Button className="w-full" variant="outline">
                                    <Database className="mr-2 h-4 w-4" />
                                    Adatbázis böngészése
                                </Button>
                            </Link>
                        </div>
                    </CardContent>
                </Card>

                {/* System Info */}
                <Card>
                    <CardHeader>
                        <CardTitle>Rendszerinformáció</CardTitle>
                        <CardDescription>
                            Fontos információk az alkalmazásról
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="space-y-4">
                            <div className="flex justify-between items-center border-b pb-2">
                                <span className="text-sm text-muted-foreground">Laravel verzió</span>
                                <span className="font-medium">11.x</span>
                            </div>
                            <div className="flex justify-between items-center border-b pb-2">
                                <span className="text-sm text-muted-foreground">React verzió</span>
                                <span className="font-medium">18.x</span>
                            </div>
                            <div className="flex justify-between items-center border-b pb-2">
                                <span className="text-sm text-muted-foreground">Inertia.js verzió</span>
                                <span className="font-medium">1.x</span>
                            </div>
                            <div className="flex justify-between items-center">
                                <span className="text-sm text-muted-foreground">Utolsó frissítés</span>
                                <span className="font-medium">2025. október 30.</span>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                {/* Admin Notes */}
                <Card className="mt-6 border-orange-200 bg-orange-50">
                    <CardHeader>
                        <CardTitle className="text-orange-900">⚠️ Admin figyelmeztetés</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p className="text-sm text-orange-800">
                            Ez az oldal csak adminisztrátorok számára elérhető. Az itt végzett műveletek
                            közvetlenül befolyásolják az adatbázist és a rendszer működését. Kérjük,
                            körültekintően járjon el!
                        </p>
                    </CardContent>
                </Card>
            </div>
        </Layout>
    );
}

