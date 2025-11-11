import { Head, useForm, Link } from '@inertiajs/react';
import Layout from '@/components/Layout';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { ArrowLeft } from 'lucide-react';

interface Driver {
    id: number;
    name: string;
    sex: string;
    birth_date: string;
    country: string;
}

interface Props {
    driver: Driver;
}

export default function Edit({ driver }: Props) {
    const { data, setData, put, processing, errors } = useForm({
        name: driver.name,
        sex: driver.sex,
        birth_date: driver.birth_date,
        country: driver.country,
    });

    function handleSubmit(e: React.FormEvent) {
        e.preventDefault();
        put(`/drivers/${driver.id}`);
    }

    return (
        <Layout>
            <Head title={`${driver.name} szerkesztése`} />

            <div className="max-w-2xl mx-auto">
                <div className="mb-6">
                    <Link href="/drivers">
                        <Button variant="ghost" size="sm">
                            <ArrowLeft className="mr-2 h-4 w-4" />
                            Vissza a listához
                        </Button>
                    </Link>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>{driver.name} szerkesztése</CardTitle>
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
                                    placeholder="Pilóta teljes neve"
                                    required
                                />
                                {errors.name && (
                                    <p className="text-sm text-red-600">{errors.name}</p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="sex">Nem *</Label>
                                <Select
                                    value={data.sex}
                                    onValueChange={(value) => setData('sex', value)}
                                >
                                    <SelectTrigger>
                                        <SelectValue placeholder="Válasszon nemet" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="F">Férfi</SelectItem>
                                        <SelectItem value="N">Nő</SelectItem>
                                    </SelectContent>
                                </Select>
                                {errors.sex && (
                                    <p className="text-sm text-red-600">{errors.sex}</p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="birth_date">Születési dátum *</Label>
                                <Input
                                    id="birth_date"
                                    type="date"
                                    value={data.birth_date}
                                    onChange={(e) => setData('birth_date', e.target.value)}
                                    required
                                />
                                {errors.birth_date && (
                                    <p className="text-sm text-red-600">{errors.birth_date}</p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="country">Ország *</Label>
                                <Input
                                    id="country"
                                    type="text"
                                    value={data.country}
                                    onChange={(e) => setData('country', e.target.value)}
                                    placeholder="Ország neve"
                                    required
                                />
                                {errors.country && (
                                    <p className="text-sm text-red-600">{errors.country}</p>
                                )}
                            </div>

                            <div className="flex gap-2">
                                <Button type="submit" disabled={processing}>
                                    {processing ? 'Mentés...' : 'Módosítások mentése'}
                                </Button>
                                <Link href="/drivers">
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

