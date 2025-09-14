import ActiveDraftController from '@/actions/App/Http/Controllers/ActiveDraftController';
import { DraftPick } from '@/components/draft/draft-pick';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { destroy } from '@/routes/active-drafts';
import { Form, Link } from '@inertiajs/react';
import clsx from 'clsx';

export default function ShowDraft({ draft, players }) {
    const pickedPlayerIds = draft.picks.map((pick) => pick.player_id).filter(Boolean);
    return (
        <AppLayout>
            <div className="grid gap-6">
                <div className="flex items-center gap-2">
                    <h1 className="text-2xl font-bold">Draft ID: {draft.id}</h1>
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
                <div className="mt-4 flex items-center gap-2 overflow-x-scroll">
                    {draft.picks.map((draftPick) => (
                        <DraftPick key={draftPick.id} draftPick={draftPick} />
                    ))}
                </div>
                <h2 className="text-xl font-bold">Available Players</h2>
                <div className="grid grid-cols-6 gap-2">
                    {players.map((player) => (
                        <div
                            key={player.id}
                            className={clsx('rounded-lg bg-accent px-4 py-2', {
                                'bg-red-500/10': pickedPlayerIds.includes(player.id),
                            })}
                        >
                            {player.first_name} {player.last_name} - {player.position}
                        </div>
                    ))}
                </div>
            </div>
        </AppLayout>
    );
}
