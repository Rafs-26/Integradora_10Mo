@extends('layouts.app')

@section('title', 'Test Navigation')
@section('page-title', 'Test Navigation')

@section('content')
<div class="p-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Navigation Test Page</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold text-gray-900 mb-2">Current User</h3>
                <p class="text-sm text-gray-600">
                    @if(Auth::check())
                        <strong>Name:</strong> {{ Auth::user()->name }}<br>
                        <strong>Email:</strong> {{ Auth::user()->email }}<br>
                        <strong>Role:</strong> {{ Auth::user()->getRoleName() ?? 'No role assigned' }}
                    @else
                        <span class="text-red-600">Not authenticated</span>
                    @endif
                </p>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold text-gray-900 mb-2">Navigation Features</h3>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>✅ Fixed positioning</li>
                    <li>✅ Session-based visibility</li>
                    <li>✅ RBAC role-based menus</li>
                    <li>✅ Responsive design</li>
                    <li>✅ Accessibility features</li>
                    <li>✅ Security measures</li>
                </ul>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold text-gray-900 mb-2">Test Actions</h3>
                <div class="space-y-2">
                    <button onclick="testNotification()" class="w-full bg-uth-green text-white px-3 py-2 rounded text-sm hover:bg-uth-green-dark">
                        Test Notification
                    </button>
                    <button onclick="testMobileMenu()" class="w-full bg-gray-600 text-white px-3 py-2 rounded text-sm hover:bg-gray-700">
                        Test Mobile Menu
                    </button>
                </div>
            </div>
        </div>
        
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="font-semibold text-blue-900 mb-2">Navigation Status</h3>
            <p class="text-sm text-blue-800">
                The navigation component has been successfully integrated with all requested features:
            </p>
            <ul class="text-sm text-blue-800 mt-2 space-y-1">
                <li>• Session control using Auth::user()</li>
                <li>• Role-based menu items for all user types</li>
                <li>• Fixed positioning with proper z-index</li>
                <li>• Responsive mobile menu with hamburger button</li>
                <li>• ARIA labels and accessibility features</li>
                <li>• XSS protection through Laravel's automatic escaping</li>
                <li>• Complete logout functionality with CSRF tokens</li>
            </ul>
        </div>
    </div>
</div>

<script>
function testNotification() {
    // Test notification system
    if (typeof notificationSystem !== 'undefined') {
        alert('Notification system is available. Check the bell icon in the navigation.');
    } else {
        alert('Notification system not loaded yet.');
    }
}

function testMobileMenu() {
    // Test mobile menu (only works on mobile or small screens)
    if (window.innerWidth < 1024) {
        alert('Mobile menu button should be visible in the navigation bar.');
    } else {
        alert('Resize your browser window to less than 1024px to test the mobile menu.');
    }
}
</script>
@endsection