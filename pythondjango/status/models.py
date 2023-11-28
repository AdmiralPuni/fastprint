from django.db import models

# Create your models here.
class Status(models.Model):
    nama = models.CharField(max_length=32)
    
    def __str__(self):
        return self.nama
    
    class Meta:
        db_table = 'status'