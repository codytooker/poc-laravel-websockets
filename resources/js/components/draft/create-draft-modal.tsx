import DraftController from '@/actions/App/Http/Controllers/DraftController';
import { Form } from '@inertiajs/react';
import { Button } from '../ui/button';
import { Dialog, DialogContent, DialogDescription, DialogTitle, DialogTrigger } from '../ui/dialog';
import { Input } from '../ui/input';
import { Label } from '../ui/label';

export function CreateDraftModal() {
    return (
        <Dialog>
            <DialogTrigger asChild>
                <Button>New Draft</Button>
            </DialogTrigger>
            <DialogContent>
                <DialogTitle>Create New Draft</DialogTitle>
                <DialogDescription>Click the button below to create a new draft.</DialogDescription>
                <Form {...DraftController.store.form()} className="grid gap-4">
                    <div className="grid gap-2">
                        <Label htmlFor="rounds">Rounds</Label>
                        <Input id="rounds" type="number" name="rounds" defaultValue={5} min={1} max={8} />
                    </div>
                    <div className="grid gap-2">
                        <Label htmlFor="time_per_pick">Pick Timer</Label>
                        <Input id="time_per_pick" type="number" name="time_per_pick" defaultValue={10} min={5} max={30} />
                    </div>
                    <Button type="submit">Create Draft</Button>
                </Form>
            </DialogContent>
        </Dialog>
    );
}
