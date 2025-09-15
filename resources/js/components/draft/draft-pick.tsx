import clsx from 'clsx';

export function DraftPick({ draftPick }) {
    return (
        <div
            className={clsx('flex aspect-square w-[150px] flex-shrink-0 rounded-2xl border-2 px-4 py-2 transition-colors duration-300', {
                'border-gray-300 bg-primary/10': draftPick.status === 'pending',
                'border-yellow-200 bg-yellow-500/10': draftPick.status === 'on_the_clock',
                'border-green-500 bg-green-500/10': draftPick.status === 'completed',
            })}
        >
            {draftPick.round}.{draftPick.pick_number} - {draftPick.team.name}{' '}
            {draftPick.player ? `(${draftPick.player.first_name} ${draftPick.player.last_name})` : ''}
        </div>
    );
}
