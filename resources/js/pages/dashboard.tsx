import { CreateDraftModal } from '@/components/draft/create-draft-modal';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { show } from '@/routes/drafts';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

export default function Dashboard({ drafts }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="my-4 flex justify-end">
                <CreateDraftModal />
            </div>
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    <ul>
                        {drafts.map((draft) => (
                            <li key={draft.id}>
                                <Link href={show({ draft: draft.id })}>
                                    Draft ID: {draft.id} - Status: {draft.status}
                                </Link>
                            </li>
                        ))}
                    </ul>
                </div>
            </div>
        </AppLayout>
    );
}
