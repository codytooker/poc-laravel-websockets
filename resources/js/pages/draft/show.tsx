/*
    TODO:

    next make an action to start the draft
        - this should 

    then make an action to complete the draft

*/

import ActiveDraftController from '@/actions/App/Http/Controllers/ActiveDraftController';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { destroy } from '@/routes/active-drafts';
import { Form, Link } from '@inertiajs/react';

export default function ShowDraft({ draft, players }) {
    return (
        <AppLayout>
            <div className="grid grid-cols-4 gap-6">
                <div className="col-span-3 p-4">
                    <h1 className="mb-4 text-2xl font-bold">Draft ID: {draft.id}</h1>
                    <p>Status: {draft.status}</p>
                    <p>Started At: {draft.started_at ?? 'N/A'}</p>
                    <p>Completed At: {draft.completed_at ?? 'N/A'}</p>

                    {draft.status === 'pending' && (
                        <Form {...ActiveDraftController.store.form()}>
                            <input type="hidden" name="draft_id" value={draft.id} />
                            <Button type="submit">Start Draft</Button>
                        </Form>
                    )}

                    {draft.status === 'active' && (
                        <Button asChild>
                            <Link href={destroy.url(draft.id)} method="delete">
                                Complete Draft
                            </Link>
                        </Button>
                    )}
                </div>

                <div className="flex h-screen flex-col gap-4 py-3">
                    <h2 className="text-xl font-bold">Players</h2>
                    <div className="flex flex-1 flex-col gap-2 overflow-y-auto">
                        {players.map((player) => (
                            <div key={player.id} className="rounded-lg bg-accent px-4 py-2">
                                {player.first_name} {player.last_name} - {player.position}
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
