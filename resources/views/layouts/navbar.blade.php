<div class="my-8 border-b">
    <ul class="flex justify-center gap-4">
        <li>
            <a href="{{ route('dropbox.index') }}" class="text-xl hover:text-blue-800 transition duration-300 {{ request()->routeIs('dropbox.index') ? 'text-blue-800' : '' }}">Dropbox</a>
        </li>
        <li>
            <a href="{{ route('dropbox.image.index') }}" class="text-xl hover:text-blue-800 transition duration-300 {{ request()->routeIs('dropbox.image.index') ? 'text-blue-800' : '' }}">Dropbox Crud</a>
        </li>
        <li>
            <a href="{{ route('dropbox.chooser') }}" class="text-xl hover:text-blue-800 transition duration-300 {{ request()->routeIs('dropbox.chooser') ? 'text-blue-800' : '' }}">Choose from dropbox</a>
        </li>
        <li>
            <a href="{{ route('dropbox.settings') }}" class="text-xl hover:text-blue-800 transition duration-300 {{ request()->routeIs('dropbox.settings') ? 'text-blue-800' : '' }}">Settings</a>
        </li>
    </ul>
</div>
