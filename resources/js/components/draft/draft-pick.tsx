export function DraftPick({ draftPick }) {
    return (
        <div className="flex aspect-square w-[150px] flex-shrink-0 rounded-2xl border-2 border-primary bg-primary/10 px-4 py-2">
            {draftPick.round}.{draftPick.pick_number} - {draftPick.team.name} {draftPick.player ? `(${draftPick.player.name})` : ''}
        </div>
    );
}
