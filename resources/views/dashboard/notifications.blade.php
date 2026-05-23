@extends('layouts.dashboard')

@section('title', 'My Notifications')

@section('dashboard_content')
<div class="space-y-8" data-aos="fade-left">
    
    <!-- Header Section -->
    <div class="border-b border-coffee-100 dark:border-gray-800 pb-5">
        <h1 class="font-display text-3xl font-extrabold text-coffee-950 dark:text-white">Notification Center</h1>
        <p class="text-sm text-coffee-600 dark:text-gray-400 mt-1">Stay updated with loyalty reward alerts and order status changes</p>
    </div>

    @if($notifications->isEmpty())
        <!-- Empty State -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-coffee-100 dark:border-gray-700 p-12 text-center shadow-warm">
            <div class="w-20 h-20 bg-amber-50 dark:bg-amber-950/20 rounded-full flex items-center justify-center mx-auto mb-6 border border-amber-100 dark:border-amber-900/50">
                <i class="fa-solid fa-bell text-3xl text-amber-500"></i>
            </div>
            <h2 class="font-display text-2xl font-bold text-coffee-900 dark:text-white mb-2">All Caught Up!</h2>
            <p class="text-coffee-600 dark:text-gray-300 max-w-md mx-auto">
                You have no new notifications. We'll alert you here when your next dessert order ships!
            </p>
        </div>
    @else
        <!-- Notification list -->
        <div class="space-y-4">
            @foreach($notifications as $notif)
                @php
                    $isUnread = is_null($notif->read_at);
                @endphp
                <div id="notif-card-{{ $notif->id }}" class="bg-white dark:bg-gray-800 rounded-2xl border transition-all duration-300 p-5 shadow-sm hover:shadow-md flex items-start gap-4 {{ $isUnread ? 'border-bakery-gold-400 bg-bakery-gold-50/10' : 'border-coffee-50 dark:border-gray-700' }}">
                    
                    <!-- Icon based on notification type -->
                    <div class="w-10 h-10 rounded-full shrink-0 flex items-center justify-center text-base {{ $isUnread ? 'bg-bakery-gold-500 text-coffee-950' : 'bg-coffee-50 dark:bg-gray-700 text-coffee-500' }}">
                        @if(str_contains(strtolower($notif->type), 'order') || str_contains(strtolower($notif->title), 'order'))
                            <i class="fa-solid fa-receipt"></i>
                        @elseif(str_contains(strtolower($notif->type), 'loyalty') || str_contains(strtolower($notif->title), 'point') || str_contains(strtolower($notif->title), 'reward'))
                            <i class="fa-solid fa-star"></i>
                        @else
                            <i class="fa-solid fa-bell"></i>
                        @endif
                    </div>

                    <!-- Texts -->
                    <div class="flex-grow min-w-0">
                        <div class="flex items-start justify-between gap-4">
                            <h3 class="font-bold text-sm text-coffee-900 dark:text-white truncate {{ $isUnread ? 'font-extrabold' : '' }}">{{ $notif->title }}</h3>
                            <span class="text-xxs text-coffee-400 dark:text-gray-500 shrink-0 whitespace-nowrap">{{ $notif->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-coffee-600 dark:text-gray-300 mt-1 leading-relaxed">{{ $notif->message }}</p>
                        
                        @if($isUnread)
                            <button onclick="markAsRead('{{ $notif->id }}', this)" class="mt-3 text-xxs font-bold uppercase tracking-widest text-bakery-gold-600 dark:text-bakery-gold-400 hover:underline flex items-center gap-1">
                                <i class="fa-solid fa-check"></i> Mark as Read
                            </button>
                        @endif
                    </div>

                </div>
            @endforeach

            <!-- Pagination -->
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    function markAsRead(id, btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner animate-spin"></i> Marking...';

        fetch(`/dashboard/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update styling of card
                const card = document.getElementById(`notif-card-${id}`);
                card.classList.remove('border-bakery-gold-400', 'bg-bakery-gold-50/10');
                card.classList.add('border-coffee-50', 'dark:border-gray-700');
                
                // Dim down the title
                const title = card.querySelector('h3');
                title.classList.remove('font-extrabold');
                title.classList.add('font-bold');

                // Recolor the icon circle
                const iconCircle = card.querySelector('.w-10');
                iconCircle.classList.remove('bg-bakery-gold-500', 'text-coffee-950');
                iconCircle.classList.add('bg-coffee-50', 'dark:bg-gray-700', 'text-coffee-500');

                // Remove the button
                btn.remove();

                window.showToast('Notification marked as read.', 'success');
            } else {
                window.showToast('Error marking notification.', 'error');
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-check"></i> Mark as Read';
            }
        })
        .catch(err => {
            console.error(err);
            window.showToast('Network error, please try again.', 'error');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Mark as Read';
        });
    }
</script>
@endpush
