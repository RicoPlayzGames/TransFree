![](public/assets/banner.png)

# TransFree

[![Stars](https://img.shields.io/github/stars/RicoPlayzGames/TransFree?style=flat-square&color=5B4FE8)](https://github.com/RicoPlayzGames/TransFree/stargazers)
[![Open Issues](https://img.shields.io/github/issues/RicoPlayzGames/TransFree?style=flat-square&color=5B4FE8)](https://github.com/RicoPlayzGames/TransFree/issues)
[![Last Commit](https://img.shields.io/github/last-commit/RicoPlayzGames/TransFree?style=flat-square&color=5B4FE8)](https://github.com/RicoPlayzGames/TransFree/commits/main)
[![Top Language](https://img.shields.io/github/languages/top/RicoPlayzGames/TransFree?style=flat-square&color=5B4FE8)](https://github.com/RicoPlayzGames/TransFree)
[![Made with PHP](https://img.shields.io/badge/Made%20with-PHP-5B4FE8?style=flat-square&logo=php&logoColor=white)](https://www.php.net/)

A Website to Upload files and transfer to other devices

## Project Status

We currently have the core upload and download functionality fully implemented and working.
We are also actively working on adding a comment system for uploaded files.
At this stage, there are no other unfinished features besides the ongoing comment system implementation.

## Security Measures

- Session Protection on Upload
- Session Protection on Download
- Integrety Checks on Upload/Download

## Installation:
1. Clone repository:

```bash
git clone https://github.com/RicoPlayzGames/TransFree.git
cd transfree
```

2. Update Config:

```bash
cd Config
```

```bash
Windows (CMD):
copy Config.example.php Config.php

Windows (PowerShell):
Copy-Item Config.example.php Config.php
```
Edit the config to use your database.
