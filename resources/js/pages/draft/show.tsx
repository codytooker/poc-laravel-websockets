import AppLayout from '@/layouts/app-layout';

export default function ShowDraft({ draft }: { draft: any }) {
    return (
        <AppLayout>
            <div className="p-4">
                <h1 className="mb-4 text-2xl font-bold">Draft ID: {draft.id}</h1>
                <p>Status: {draft.status}</p>
                <p>Started At: {draft.started_at ?? 'N/A'}</p>
                <p>Completed At: {draft.completed_at ?? 'N/A'}</p>
            </div>
        </AppLayout>
    );
}
