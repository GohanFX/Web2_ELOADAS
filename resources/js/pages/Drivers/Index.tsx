import { Head, Link, router } from '@inertiajs/react';
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
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Pencil, Trash2, Plus } from 'lucide-react';

interface Driver {
    id: number;
    name: string;
    sex: string;
    birth_date: string;
    country: string;
}

interface Props {
    drivers: {
        data: Driver[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
}

export default function Index({ drivers }: Props) {
    const formatDate = (dateString: string) => {
        const date = new Date(dateString);
        return new Intl.DateTimeFormat('hu-HU', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        }).format(date);
    };

    const handleDelete = (id: number, name: string) => {
        if (confirm(`Biztosan törölni szeretnéd a következő pilótát: ${name}?`)) {
            router.delete(`/drivers/${id}`);
        }
    };

    return (
        <Layout>
            <Head title="Pilóták kezelése" />

            <div>
                <div className="flex justify-between items-center mb-8">
                    <div>
                        <h1 className="text-4xl font-bold mb-2">Pilóták kezelése (CRUD)</h1>
                        <p className="text-muted-foreground">
                            Pilóták létrehozása, szerkesztése és törlése
                        </p>
                    </div>
                    <Link href="/drivers/create">
                        <Button>
                            <Plus className="mr-2 h-4 w-4" />
                            Új pilóta
                        </Button>
                    </Link>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>
                            Összes pilóta ({drivers.total})
                        </CardTitle>
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
                                        <TableHead className="text-right">Műveletek</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {drivers.data.map((driver) => (
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
                                            <TableCell className="text-right">
                                                <div className="flex justify-end gap-2">
                                                    <Link href={`/drivers/${driver.id}/edit`}>
                                                        <Button variant="outline" size="sm">
                                                            <Pencil className="h-4 w-4" />
                                                        </Button>
                                                    </Link>
                                                    <Button
                                                        variant="destructive"
                                                        size="sm"
                                                        onClick={() => handleDelete(driver.id, driver.name)}
                                                    >
                                                        <Trash2 className="h-4 w-4" />
                                                    </Button>
                                                </div>
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </div>

                        {/* Pagination */}
                        {drivers.last_page > 1 && (
                            <div className="flex justify-center gap-2 mt-4">
                                {Array.from({ length: drivers.last_page }, (_, i) => i + 1).map((page) => (
                                    <Link key={page} href={`/drivers?page=${page}`}>
                                        <Button
                                            variant={drivers.current_page === page ? 'default' : 'outline'}
                                            size="sm"
                                        >
                                            {page}
                                        </Button>
                                    </Link>
                                ))}
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </Layout>
    );
}

