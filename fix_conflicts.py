import re
import sys

files_to_fix = [
    'resources/views/components/layouts/admin.blade.php',
    'resources/views/components/layouts/app.blade.php',
    'resources/views/livewire/admin/settings.blade.php',
    'resources/views/livewire/client/catalog.blade.php',
    'resources/views/livewire/client/card.blade.php',
    'resources/views/livewire/client/companies.blade.php'
]

for filepath in files_to_fix:
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Remove conflict markers - keep the "theirs" version (after =======)
        # Pattern: <<<<<<< HEAD\n...content...\n=======\n...keep this...\n>>>>>>> hash
        pattern = r'<<<<<<< HEAD\n(.*?)\n=======\n(.*?)\n>>>>>>> [a-f0-9]+\n'
        content = re.sub(pattern, r'\2\n', content, flags=re.DOTALL)
        
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        
        print(f"Fixed: {filepath}")
    except Exception as e:
        print(f"Error fixing {filepath}: {e}")

print("All conflicts resolved!")
