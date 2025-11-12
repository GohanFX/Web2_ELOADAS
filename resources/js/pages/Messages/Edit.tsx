import { Head, useForm, Link } from '@inertiajs/react';
import Layout from '@/components/Layout';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { ArrowLeft } from 'lucide-react';

interface Contact {
    id: number;
    name: string;
    email: string;
    subject: string | null;
    message: string;
}

interface Props {
    contact: Contact;
}

export default function Edit({ contact }: Props) {
    const { data, setData, put, processing, errors } = useForm({
        name: contact.name,
        email: contact.email,
        subject: contact.subject ?? '',
        message: contact.message,
    });

    function handleSubmit(e: React.FormEvent) {
        e.preventDefault();
        put(`/contacts/${contact.id}`);
    }

    return (
        <Layout>
            <Head title={`${contact.name} szerkesztése`} />

            <div className="max-w-2xl mx-auto">
                <div className="mb-6">
                    <Link href="/messages">
                        <Button variant="ghost" size="sm">
                            <ArrowLeft className="mr-2 h-4 w-4" />
                            Vissza az üzenetekhez
                        </Button>
                    </Link>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>{contact.name} szerkesztése</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={handleSubmit} className="space-y-4">
                            <div className="space-y-2">
                                <Label htmlFor="name">Név *</Label>
                                <Input
                                    id="name"
                                    type="text"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    required
                                />
                                {errors.name && (
                                    <p className="text-sm text-red-600">{errors.name}</p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="email">Email *</Label>
                                <Input
                                    id="email"
                                    type="email"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                    required
                                />
                                {errors.email && (
                                    <p className="text-sm text-red-600">{errors.email}</p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="subject">Tárgy</Label>
                                <Input
                                    id="subject"
                                    type="text"
                                    value={data.subject}
                                    onChange={(e) => setData('subject', e.target.value)}
                                />
                                {errors.subject && (
                                    <p className="text-sm text-red-600">{errors.subject}</p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="message">Üzenet *</Label>
                                <Textarea
                                    id="message"
                                    value={data.message}
                                    onChange={(e) => setData('message', e.target.value)}
                                    rows={6}
                                    required
                                />
                                {errors.message && (
                                    <p className="text-sm text-red-600">{errors.message}</p>
                                )}
                            </div>

                            <div className="flex gap-2">
                                <Button type="submit" disabled={processing}>
                                    {processing ? 'Mentés...' : 'Módosítások mentése'}
                                </Button>
                                <Link href="/messages">
                                    <Button type="button" variant="outline">
                                        Mégse
                                    </Button>
                                </Link>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </Layout>
    );
}
