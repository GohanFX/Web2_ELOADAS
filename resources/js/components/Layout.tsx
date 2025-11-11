import { Link, usePage } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
} from '@/components/ui/navigation-menu';
import { ReactNode } from 'react';
import { Alert, AlertDescription } from '@/components/ui/alert';

interface LayoutProps {
    children: ReactNode;
}

interface PageProps {
    auth: {
        user: {
            id: number;
            name: string;
            email: string;
            role: string;
        } | null;
    };
    flash: {
        success?: string;
        error?: string;
    };
}

export default function Layout({ children }: LayoutProps) {
    const { auth, flash } = usePage<PageProps>().props;

    return (
        <div className="min-h-screen bg-background">
            <header className="border-b">
                <div className="container mx-auto px-4 py-4">
                    <nav className="flex items-center justify-between">
                        <div className="flex items-center gap-8">
                            <Link href="/" className="text-xl font-bold">
                                Formula 1 Adatbázis
                            </Link>

                            <NavigationMenu>
                                <NavigationMenuList>
                                    <NavigationMenuItem>
                                        <Link href="/">
                                            <NavigationMenuLink className="px-4 py-2 hover:bg-accent rounded-md">
                                                Főoldal
                                            </NavigationMenuLink>
                                        </Link>
                                    </NavigationMenuItem>

                                    <NavigationMenuItem>
                                        <Link href="/database">
                                            <NavigationMenuLink className="px-4 py-2 hover:bg-accent rounded-md">
                                                Adatbázis
                                            </NavigationMenuLink>
                                        </Link>
                                    </NavigationMenuItem>

                                    <NavigationMenuItem>
                                        <Link href="/contact">
                                            <NavigationMenuLink className="px-4 py-2 hover:bg-accent rounded-md">
                                                Kapcsolat
                                            </NavigationMenuLink>
                                        </Link>
                                    </NavigationMenuItem>

                                    <NavigationMenuItem>
                                        <Link href="/chart">
                                            <NavigationMenuLink className="px-4 py-2 hover:bg-accent rounded-md">
                                                Diagram
                                            </NavigationMenuLink>
                                        </Link>
                                    </NavigationMenuItem>

                                    {auth.user && (
                                        <NavigationMenuItem>
                                            <Link href="/messages">
                                                <NavigationMenuLink className="px-4 py-2 hover:bg-accent rounded-md">
                                                    Üzenetek
                                                </NavigationMenuLink>
                                            </Link>
                                        </NavigationMenuItem>
                                    )}

                                    {auth.user?.role === 'admin' && (
                                        <>
                                            <NavigationMenuItem>
                                                <Link href="/drivers">
                                                    <NavigationMenuLink className="px-4 py-2 hover:bg-accent rounded-md">
                                                        CRUD
                                                    </NavigationMenuLink>
                                                </Link>
                                            </NavigationMenuItem>
                                            <NavigationMenuItem>
                                                <Link href="/admin">
                                                    <NavigationMenuLink className="px-4 py-2 hover:bg-accent rounded-md">
                                                        Admin
                                                    </NavigationMenuLink>
                                                </Link>
                                            </NavigationMenuItem>
                                        </>
                                    )}
                                </NavigationMenuList>
                            </NavigationMenu>
                        </div>

                        <div className="flex items-center gap-4">
                            {auth.user ? (
                                <>
                                    <span className="text-sm text-muted-foreground">
                                        Üdv, {auth.user.name}!
                                    </span>
                                    <Link href="/auth/logout" method="post" as="button">
                                        <Button variant="outline">Kijelentkezés</Button>
                                    </Link>
                                </>
                            ) : (
                                <>
                                    <Link href="/auth/login">
                                        <Button variant="outline">Bejelentkezés</Button>
                                    </Link>
                                    <Link href="/auth/register">
                                        <Button>Regisztráció</Button>
                                    </Link>
                                </>
                            )}
                        </div>
                    </nav>
                </div>
            </header>

            <main className="container mx-auto px-4 py-8">
                {flash.success && (
                    <Alert className="mb-4 bg-green-50 border-green-200">
                        <AlertDescription className="text-green-800">
                            {flash.success}
                        </AlertDescription>
                    </Alert>
                )}

                {flash.error && (
                    <Alert className="mb-4 bg-red-50 border-red-200">
                        <AlertDescription className="text-red-800">
                            {flash.error}
                        </AlertDescription>
                    </Alert>
                )}

                {children}
            </main>

            <footer className="border-t mt-16">
                <div className="container mx-auto px-4 py-6 text-center text-sm text-muted-foreground">
                    © 2025 Formula 1 Adatbázis. Minden jog fenntartva.
                </div>
            </footer>
        </div>
    );
}

