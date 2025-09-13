import AppLayout from '@/layouts/app-layout';

export default function PlayerShow({ player }: { player: { id: number; first_name: string; last_name: string; position: string } }) {
    return (
        <AppLayout>
            <div>
                <h1>
                    {player.first_name} {player.last_name}
                </h1>
                <p>Position: {player.position}</p>
            </div>
        </AppLayout>
    );
}
