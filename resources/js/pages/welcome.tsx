import { Head } from '@inertiajs/react';
import Layout from '@/components/Layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/react';

export default function Welcome() {
    return (
        <Layout>
            <Head title="Főoldal" />

            <div className="space-y-8">
                {/* Hero Section */}
                <div className="text-center py-12 bg-gradient-to-r from-red-50 to-gray-50 rounded-lg">
                    <h1 className="text-5xl font-bold mb-4">
                        Formula 1 Adatbázis
                    </h1>
                    <p className="text-xl text-muted-foreground mb-8">
                        Fedezd fel a Formula 1 történelmét pilóták, versenyek és eredmények alapján
                    </p>
                    <div className="flex gap-4 justify-center">
                        <Link href="/database">
                            <Button size="lg">Adatbázis böngészése</Button>
                        </Link>
                        <Link href="/chart">
                            <Button size="lg" variant="outline">Statisztikák</Button>
                        </Link>
                    </div>
                </div>

                {/* Features */}
                <div className="grid md:grid-cols-3 gap-6">
                    <Card>
                        <CardHeader>
                            <CardTitle>Pilóták adatbázisa</CardTitle>
                            <CardDescription>
                                Böngészd át a Formula 1 történelmének legnagyobb pilótáit
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <p className="text-sm text-muted-foreground">
                                Részletes információk születési dátumokról, nemzetiségről és eredményekről.
                            </p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Versenyek nyomon követése</CardTitle>
                            <CardDescription>
                                Nézd meg a múlt és jelenlegi versenyeket
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <p className="text-sm text-muted-foreground">
                                Grand Prix-ek, helyezések és részletes eredmények az évek során.
                            </p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Statisztikák és diagramok</CardTitle>
                            <CardDescription>
                                Vizualizáld az adatokat interaktív diagramokkal
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <p className="text-sm text-muted-foreground">
                                Országok szerinti eloszlás, évenkénti versenyek és több.
                            </p>
                        </CardContent>
                    </Card>
                </div>

                {/* About Section */}
                <div className="bg-card rounded-lg p-8 border">
                    <h2 className="text-3xl font-bold mb-4">Rólunk</h2>
                    <div className="prose max-w-none">
                        <p className="text-muted-foreground mb-4">
                            Üdvözöljük a Formula 1 Adatbázis weboldalon! Ez az alkalmazás
                            a Formula 1 versenyautó-sport gazdag történetét mutatja be,
                            részletes információkkal a pilótákról, versenyekről és eredményekről.
                        </p>
                        <p className="text-muted-foreground mb-4">
                            Oldalunkon böngészhetsz a több mint 850 pilóta adatai között,
                            megnézheted a 750+ Grand Prix verseny részleteit, és interaktív
                            diagramokkal elemezheted a sport statisztikáit.
                        </p>
                        <p className="text-muted-foreground">
                            Regisztrálj, hogy hozzáférj az összes funkcióhoz, beleértve
                            az üzenetküldést és a speciális adminisztrációs eszközöket!
                        </p>
                    </div>
                </div>
            </div>
        </Layout>
    );
}

