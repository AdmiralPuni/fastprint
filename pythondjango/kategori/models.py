from django.db import models

# Create your models here.
class Kategori(models.Model):
    nama = models.CharField(max_length=128)
    
    def __str__(self):
        return self.nama
    
    class Meta:
        db_table = 'kategori'