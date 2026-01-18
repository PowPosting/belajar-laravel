import re
import sys

def convert_mysql_to_postgres(input_file, output_file):
    """Convert MySQL dump to PostgreSQL compatible format"""
    
    print(f"📖 Membaca file: {input_file}")
    with open(input_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    print("🔧 Mengkonversi syntax MySQL ke PostgreSQL...")
    
    # Remove MySQL specific commands
    content = re.sub(r'SET FOREIGN_KEY_CHECKS=\d+;', '', content)
    content = re.sub(r'SET SQL_MODE\s*=\s*"[^"]*";', '', content)
    
    # Convert backticks to double quotes for identifiers
    content = content.replace('`', '"')
    
    # Convert INT(n) to INTEGER
    content = re.sub(r'INT\(\d+\)', 'INTEGER', content, flags=re.IGNORECASE)
    
    # Convert BIGINT(n) to BIGINT
    content = re.sub(r'BIGINT\(\d+\)', 'BIGINT', content, flags=re.IGNORECASE)
    
    # Convert AUTO_INCREMENT to SERIAL or use SEQUENCE
    content = re.sub(
        r'"id"\s+BIGINT\s+NOT NULL\s+AUTO_INCREMENT',
        '"id" SERIAL PRIMARY KEY',
        content,
        flags=re.IGNORECASE
    )
    
    # Remove ENGINE and CHARSET
    content = re.sub(
        r'ENGINE=\w+\s+DEFAULT\s+CHARSET=\w+',
        '',
        content,
        flags=re.IGNORECASE
    )
    
    # Convert INDEX to CREATE INDEX (move outside CREATE TABLE)
    # For now, just remove inline INDEX definitions
    content = re.sub(r',\s*INDEX\s+"[^"]+"\s*\([^)]+\)', '', content, flags=re.IGNORECASE)
    content = re.sub(r',\s*UNIQUE\s+INDEX\s+"[^"]+"\s*\([^)]+\)', '', content, flags=re.IGNORECASE)
    
    # Fix PRIMARY KEY definition
    content = re.sub(r',\s*PRIMARY KEY\s*\("id"\)', '', content, flags=re.IGNORECASE)
    
    # Add BEGIN and COMMIT for transaction
    if 'BEGIN;' not in content:
        content = 'BEGIN;\n\n' + content
    if 'COMMIT;' not in content:
        content += '\n\nCOMMIT;\n'
    
    print(f"💾 Menyimpan ke: {output_file}")
    with open(output_file, 'w', encoding='utf-8') as f:
        f.write(content)
    
    print("✅ Konversi selesai!")
    print(f"\n📊 File siap diimport ke PostgreSQL: {output_file}")

if __name__ == '__main__':
    input_file = 'mysql_provinces.sql'
    output_file = 'postgres_provinces.sql'
    
    try:
        convert_mysql_to_postgres(input_file, output_file)
        print("\n🚀 Untuk import, jalankan:")
        print(f'   $env:PGPASSWORD="password"; psql -U postgres -d mysql_provinces -f "{output_file}"')
    except FileNotFoundError:
        print(f"❌ Error: File '{input_file}' tidak ditemukan!")
        sys.exit(1)
    except Exception as e:
        print(f"❌ Error: {e}")
        sys.exit(1)
