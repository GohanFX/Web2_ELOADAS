import { Head, Link, useForm } from '@inertiajs/react';
import Layout from '@/components/Layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';

export default function Login() {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    function handleSubmit(e: React.FormEvent) {
        e.preventDefault();
        post('/auth/login');
    }

    return (
        <Layout>
            <Head title="Bejelentkezés" />

            <div className="max-w-md mx-auto mt-12">
                <Card>
                    <CardHeader>
                        <CardTitle>Bejelentkezés</CardTitle>
                        <CardDescription>
                            Jelentkezz be a fiókodba az összes funkció eléréséhez
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={handleSubmit} className="space-y-4">
                            <div className="space-y-2">
                                <Label htmlFor="email">Email cím</Label>
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
                                <Label htmlFor="password">Jelszó</Label>
                                <Input
                                    id="password"
                                    type="password"
                                    value={data.password}
                                    onChange={(e) => setData('password', e.target.value)}
                                    required
                                />
                                {errors.password && (
                                    <p className="text-sm text-red-600">{errors.password}</p>
                                )}
                            </div>

                            <div className="flex items-center space-x-2">
                                <Checkbox
                                    id="remember"
                                    checked={data.remember}
                                    onCheckedChange={(checked) => setData('remember', !!checked)}
                                />
                                <Label htmlFor="remember" className="text-sm cursor-pointer">
                                    Emlékezz rám
                                </Label>
                            </div>

                            <Button type="submit" className="w-full" disabled={processing}>
                                {processing ? 'Bejelentkezés...' : 'Bejelentkezés'}
                            </Button>

                            <div className="text-center text-sm">
                                <span className="text-muted-foreground">Nincs még fiókod? </span>
                                <Link href="/auth/register" className="text-primary hover:underline">
                                    Regisztrálj
                                </Link>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </Layout>
    );
}

