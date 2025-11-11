import { Head } from '@inertiajs/react';
import Layout from '@/components/Layout';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Badge } from '@/components/ui/badge';

interface Driver {
    id: number;
    name: string;
    sex: string;
    birth_date: string;
    country: string;
}

interface GP {
    id: number;
    name: string;
    date: string;
    location: string;
}

interface Race {
    id: number;
    date: string;
    placement: number | null;
    mistake: boolean;
    team: string;
    driver: Driver;
}

interface Props {
    drivers: Driver[];
    gps: GP[];
    races: Race[];
}

export default function Index({ drivers, gps, races }: Props) {
    const formatDate = (dateString: string) => {
        const date = new Date(dateString);
        return new Intl.DateTimeFormat('hu-HU', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        }).format(date);
    };

    return (
        <Layout>
            <Head title="Adatbázis" />

            <div>
                <div className="mb-8">
                    <h1 className="text-4xl font-bold mb-2">Formula 1 Adatbázis</h1>
                    <p className="text-muted-foreground">
                        Böngésszen a pilóták, verseny események és eredmények között
                    </p>
                </div>

                <Tabs defaultValue="drivers" className="space-y-4">
                    <TabsList>
                        <TabsTrigger value="drivers">Pilóták</TabsTrigger>
                        <TabsTrigger value="gps">Grand Prix-k</TabsTrigger>
                        <TabsTrigger value="races">Versenyek</TabsTrigger>
                    </TabsList>

                    <TabsContent value="drivers">
                        <Card>
                            <CardHeader>
                                <CardTitle>Pilóták ({drivers.length})</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="overflow-x-auto">
                                    <Table>
                                        <TableHeader>
                                            <TableRow>
                                                <TableHead>ID</TableHead>
                                                <TableHead>Név</TableHead>
                                                <TableHead>Nem</TableHead>
                                                <TableHead>Születési dátum</TableHead>
                                                <TableHead>Ország</TableHead>
                                            </TableRow>
                                        </TableHeader>
                                        <TableBody>
                                            {drivers.map((driver) => (
                                                <TableRow key={driver.id}>
                                                    <TableCell>{driver.id}</TableCell>
                                                    <TableCell className="font-medium">
                                                        {driver.name}
                                                    </TableCell>
                                                    <TableCell>
                                                        <Badge variant={driver.sex === 'F' ? 'default' : 'secondary'}>
                                                            {driver.sex === 'F' ? 'Férfi' : 'Nő'}
                                                        </Badge>
                                                    </TableCell>
                                                    <TableCell>
                                                        {formatDate(driver.birth_date)}
                                                    </TableCell>
                                                    <TableCell>{driver.country}</TableCell>
                                                </TableRow>
                                            ))}
                                        </TableBody>
                                    </Table>
                                </div>
                            </CardContent>
                        </Card>
                    </TabsContent>

                    <TabsContent value="gps">
                        <Card>
                            <CardHeader>
                                <CardTitle>Grand Prix versenyek ({gps.length})</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="overflow-x-auto">
                                    <Table>
                                        <TableHeader>
                                            <TableRow>
                                                <TableHead>ID</TableHead>
                                                <TableHead>Név</TableHead>
                                                <TableHead>Dátum</TableHead>
                                                <TableHead>Helyszín</TableHead>
                                            </TableRow>
                                        </TableHeader>
                                        <TableBody>
                                            {gps.map((gp) => (
                                                <TableRow key={gp.id}>
                                                    <TableCell>{gp.id}</TableCell>
                                                    <TableCell className="font-medium">
                                                        {gp.name}
                                                    </TableCell>
                                                    <TableCell>
                                                        {formatDate(gp.date)}
                                                    </TableCell>
                                                    <TableCell>{gp.location}</TableCell>
                                                </TableRow>
                                            ))}
                                        </TableBody>
                                    </Table>
                                </div>
                            </CardContent>
                        </Card>
                    </TabsContent>

                    <TabsContent value="races">
                        <Card>
                            <CardHeader>
                                <CardTitle>Versenyek ({races.length})</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="overflow-x-auto">
                                    <Table>
                                        <TableHeader>
                                            <TableRow>
                                                <TableHead>Pilóta</TableHead>
                                                <TableHead>Dátum</TableHead>
                                                <TableHead>Helyezés</TableHead>
                                                <TableHead>Csapat</TableHead>
                                                <TableHead>Státusz</TableHead>
                                            </TableRow>
                                        </TableHeader>
                                        <TableBody>
                                            {races.map((race) => (
                                                <TableRow key={race.id}>
                                                    <TableCell className="font-medium">
                                                        {race.driver?.name || 'Ismeretlen'}
                                                    </TableCell>
                                                    <TableCell>
                                                        {formatDate(race.date)}
                                                    </TableCell>
                                                    <TableCell>
                                                        {race.placement ? (
                                                            <Badge variant="default">
                                                                {race.placement}. hely
                                                            </Badge>
                                                        ) : (
                                                            <Badge variant="destructive">
                                                                DNF
                                                            </Badge>
                                                        )}
                                                    </TableCell>
                                                    <TableCell>{race.team}</TableCell>
                                                    <TableCell>
                                                        {race.mistake ? (
                                                            <Badge variant="destructive">
                                                                Hiba
                                                            </Badge>
                                                        ) : (
                                                            <Badge variant="secondary">
                                                                OK
                                                            </Badge>
                                                        )}
                                                    </TableCell>
                                                </TableRow>
                                            ))}
                                        </TableBody>
                                    </Table>
                                </div>
                            </CardContent>
                        </Card>
                    </TabsContent>
                </Tabs>
            </div>
        </Layout>
    );
}

