# NextGenSim
WordPress Plugin for sfcir.org NextGenSim web simulation

# Purpose
The purpose of this program is to allow SFCIR employees to be able to manually enter new characters into their NextGenSim learning tool.

# Versions
1.0

# Installation
Simply download the zip file, and install usi8ng your WordPress plugin manager in your WordPress administrator dashboard.

# support
For bug reports and technical please feel free to contact me any time *joshuarg@nmsu.edu*

# Developer Notes

1. This program creates two custom post types (CPT), Character and Year
  - 'character' => [character title, year, profile, character number, insider info, goal, password]
  - 'year'      => [year, admin password, secret password]
  
2. These CPTs are then used to create a list of characters for individual years
  - Each character can only have one year
  - Each year can only contain one of each character number
  - This allows loading all characters from the same year without repeating duplicate character numbers
  