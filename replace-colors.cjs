const fs = require('fs');
const path = require('path');

const directories = [
    path.join(__dirname, 'resources', 'views', 'manager'),
    path.join(__dirname, 'resources', 'views', 'customer'),
    path.join(__dirname, 'resources', 'views', 'therapist')
];

const replacements = {
    'bg-white': 'bg-spa-white',
    'bg-gray-50': 'bg-spa-cream',
    'bg-gray-100': 'bg-spa-beige',
    'border-gray-100': 'border-spa-beige',
    'border-gray-200': 'border-spa-beige',
    'border-gray-300': 'border-spa-wood',
    'text-gray-900': 'text-spa-charcoal',
    'text-gray-800': 'text-spa-charcoal',
    'text-gray-700': 'text-spa-charcoal opacity-90',
    'text-gray-600': 'text-spa-gray',
    'text-gray-500': 'text-spa-gray opacity-80',
    'text-gray-400': 'text-spa-gray opacity-60',
    'text-indigo-600': 'text-spa-gold',
    'text-indigo-500': 'text-spa-gold',
    'bg-indigo-600': 'bg-spa-brown',
    'bg-indigo-500': 'bg-spa-wood',
    'hover:bg-gray-50': 'hover:bg-spa-beige',
    'hover:bg-gray-100': 'hover:bg-spa-beige opacity-80',
    'hover:text-gray-900': 'hover:text-spa-charcoal',
    'focus:border-indigo-500': 'focus:border-spa-gold',
    'focus:ring-indigo-500': 'focus:ring-spa-gold',
    'ring-gray-300': 'ring-spa-beige'
};

function processDirectory(dir) {
    if (!fs.existsSync(dir)) return;
    
    const files = fs.readdirSync(dir);
    for (const file of files) {
        const fullPath = path.join(dir, file);
        if (fs.statSync(fullPath).isDirectory()) {
            processDirectory(fullPath);
        } else if (fullPath.endsWith('.blade.php')) {
            let content = fs.readFileSync(fullPath, 'utf8');
            let modified = false;
            
            for (const [search, replace] of Object.entries(replacements)) {
                // Using regex to match class names precisely with word boundaries
                // However, for tailwind classes like hover:bg-gray-50, \b won't match the colon correctly in standard JS
                // Since it's CSS classes, we'll do a simple split and join on spaces and quotes, or simpler regex
                // We'll use lookarounds to ensure we are replacing full class names
                const regex = new RegExp(`(?<=[\\s"'])(${search.replace(/:/g, '\\:')})(?=[\\s"'])`, 'g');
                if (regex.test(content)) {
                    content = content.replace(regex, replace);
                    modified = true;
                }
            }
            
            if (modified) {
                fs.writeFileSync(fullPath, content, 'utf8');
                console.log(`Updated: ${fullPath}`);
            }
        }
    }
}

directories.forEach(dir => processDirectory(dir));
console.log('Done replacing colors.');
