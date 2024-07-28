const mix = require('laravel-mix');
const fs = require('fs');
const path = require('path');

// Set public path for build output and enable versioning
mix.setPublicPath('build').version();

// Disable manifest file generation
mix.options({ manifest: false });

// Define the root directory and the release manifest file path
const root_dir = path.resolve(__dirname, '../');
const file_path = path.join(root_dir, '.release-please-manifest.json');

let version_number;

try {
    // Read the version number from the manifest file
    const data = fs.readFileSync(file_path, 'utf8');
    const json_object = JSON.parse(data);
    version_number = json_object["."];
    console.log('Version number:', version_number);
} catch (err) {
    console.error('Error reading the file:', err);
}

// Define directories and files
const directories = {
    svn_root_dir: path.join(root_dir, 'build/svn'),
    svn_tags_dir: path.join(root_dir, 'build/svn/tags'),
    svn_trunk_dir: path.join(root_dir, 'build/svn/trunk'),
    svn_tag_version_dir: path.join(root_dir, 'build/svn/tags', version_number),
    build_trunk_dir: 'build/trunk'
};

const files_to_copy = [
    'index.php',
    'LICENSE',
    'readme.txt',
    'sim-site-maintenance.php',
];

// Function to create directories
const create_directory = (dir_path) => {
    if (!fs.existsSync(dir_path)) {
        fs.mkdirSync(dir_path, { recursive: true });
        console.log('Directory created successfully:', dir_path);
    }
};

// Create SVN directories
create_directory(directories.svn_root_dir);
create_directory(directories.svn_tags_dir);
create_directory(directories.svn_trunk_dir);
create_directory(directories.svn_tag_version_dir);

// Function to copy files and directories
const copy_files_and_directories = (destination_dir) => {
    mix.copy('vendor', path.join(destination_dir, 'vendor'))
       .copy('src', path.join(destination_dir, 'src'))
       .copy(files_to_copy, destination_dir);
};

// Copy files and directories to the SVN trunk
copy_files_and_directories(directories.svn_trunk_dir);

// Copy files and directories to the SVN tags for versioning
copy_files_and_directories(directories.svn_tag_version_dir);

// Maintain backward compatibility with build/trunk
copy_files_and_directories(directories.build_trunk_dir);

// Log the version number used in the build process after mix operations
mix.then(() => {
    console.log('Current version number in build process:', version_number);
});
