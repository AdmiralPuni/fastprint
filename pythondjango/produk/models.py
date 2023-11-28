from django.db import models

# Create your models here.
class Produk(models.Model):
    nama = models.TextField()
    harga = models.IntegerField()
    kategori = models.ForeignKey('kategori.Kategori', on_delete=models.RESTRICT)
    status = models.ForeignKey('status.Status', on_delete=models.RESTRICT)
    
    def __str__(self):
        return self.nama
    
    class Meta:
        db_table = 'produk'