import { Head, useForm } from '@inertiajs/react';
import Layout from '@/components/Layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';

export default function Create() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        subject: '',
        message: '',
    });

    function handleSubmit(e: React.FormEvent) {
        e.preventDefault();
        post('/contact', {
            onSuccess: () => reset(),
        });
    }

    return (
        <Layout>
            <Head title="Kapcsolat" />

            <div className="max-w-2xl mx-auto">
                <div className="mb-8">
                    <h1 className="text-4xl font-bold mb-2">Kapcsolat</h1>
                    <p className="text-muted-foreground">
                        Küldjön nekünk üzenetet, és hamarosan válaszolunk!
                    </p>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Kapcsolatfelvételi űrlap</CardTitle>
                        <CardDescription>
                            Töltse ki az alábbi űrlapot, hogy üzenetet küldjön nekünk
                        </CardDescription>
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
                                    placeholder="Teljes név"
                                    required
                                />
                                {errors.name && (
                                    <p className="text-sm text-red-600">{errors.name}</p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="email">Email cím *</Label>
                                <Input
                                    id="email"
                                    type="email"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                    placeholder="pelda@email.com"
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
                                    placeholder="Az üzenet tárgya"
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
                                    placeholder="Írja ide az üzenetét..."
                                    rows={6}
                                    required
                                />
                                {errors.message && (
                                    <p className="text-sm text-red-600">{errors.message}</p>
                                )}
                                <p className="text-xs text-muted-foreground">
                                    Minimum 10 karakter szükséges
                                </p>
                            </div>

                            <Button type="submit" className="w-full" disabled={processing}>
                                {processing ? 'Küldés...' : 'Üzenet küldése'}
                            </Button>
                        </form>
                    </CardContent>
                </Card>

                <Card className="mt-6">
                    <CardHeader>
                        <CardTitle>Kapcsolattartási információk</CardTitle>
                    </CardHeader>
                    <CardContent className="space-y-2">
                        <p><strong>Email:</strong> info@formula1adatbazis.hu</p>
                        <p><strong>Telefon:</strong> +36 1 234 5678</p>
                        <p><strong>Cím:</strong> 1234 Budapest, Példa utca 12.</p>
                    </CardContent>
                </Card>
            </div>
        </Layout>
    );
}

