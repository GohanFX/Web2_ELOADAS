import { Head, useForm, Link } from '@inertiajs/react';
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
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Trash2, Edit as EditIcon } from 'lucide-react';

interface Contact {
    id: number;
    name: string;
    email: string;
    subject: string | null;
    message: string;
    created_at: string;
}

interface Props {
    contacts: Contact[];
}

export default function Index({ contacts }: Props) {
    const formatDate = (dateString: string) => {
        const date = new Date(dateString);
        return new Intl.DateTimeFormat('hu-HU', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        }).format(date);
    };

    return (
        <Layout>
            <Head title="Üzenetek" />

            <div>
                <div className="mb-8">
                    <h1 className="text-4xl font-bold mb-2">Üzenetek</h1>
                    <p className="text-muted-foreground">
                        Az összes beérkezett üzenet megtekintése fordított időrend szerint
                    </p>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Beérkezett üzenetek ({contacts.length})</CardTitle>
                    </CardHeader>
                    <CardContent>
                        {contacts.length === 0 ? (
                            <p className="text-center text-muted-foreground py-8">
                                Még nincsenek beérkezett üzenetek.
                            </p>
                        ) : (
                            <div className="overflow-x-auto">
                                <Table>
                                    <TableHeader>
                                        <TableRow>
                                            <TableHead>Név</TableHead>
                                            <TableHead>Email</TableHead>
                                            <TableHead>Tárgy</TableHead>
                                            <TableHead>Üzenet</TableHead>
                                            <TableHead>Küldés ideje</TableHead>
                                            <TableHead>Műveletek</TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        {contacts.map((contact) => (
                                            <TableRow key={contact.id}>
                                                <TableCell className="font-medium">
                                                    {contact.name}
                                                </TableCell>
                                                <TableCell>
                                                    <a
                                                        href={`mailto:${contact.email}`}
                                                        className="text-primary hover:underline"
                                                    >
                                                        {contact.email}
                                                    </a>
                                                </TableCell>
                                                <TableCell>
                                                    {contact.subject ? (
                                                        <Badge variant="secondary">
                                                            {contact.subject}
                                                        </Badge>
                                                    ) : (
                                                        <span className="text-muted-foreground italic">
                                                            Nincs tárgy
                                                        </span>
                                                    )}
                                                </TableCell>
                                                <TableCell className="max-w-md">
                                                    <p className="truncate">
                                                        {contact.message}
                                                    </p>
                                                </TableCell>
                                                <TableCell className="whitespace-nowrap">
                                                    {formatDate(contact.created_at)}
                                                </TableCell>
                                                <TableCell className="whitespace-nowrap">
                                                    <div className="flex items-center gap-2">
                                                        <Link href={`/contacts/${contact.id}/edit`}>
                                                            <Button size="sm" variant="ghost" className="p-1">
                                                                <EditIcon className="h-4 w-4" />
                                                            </Button>
                                                        </Link>
                                                        <DeleteButton id={contact.id} />
                                                    </div>
                                                </TableCell>
                                            </TableRow>
                                        ))}
                                    </TableBody>
                                </Table>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </Layout>
    );
}

function DeleteButton({ id }: { id: number }) {
    const { delete: destroy, processing } = useForm();

    function handleDelete() {
        if (!confirm('Biztosan törölni szeretné ezt az üzenetet?')) return;
        destroy(`/contacts/${id}`);
    }

    return (
        <Button size="sm" variant="destructive" onClick={handleDelete} disabled={processing} className="p-1">
            <Trash2 className="h-4 w-4" />
        </Button>
    );
}

