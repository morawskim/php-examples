package main

import (
	"bytes"
	"fmt"
	"github.com/gen2brain/shm"
	"os"
)

func main() {
	// Create a key to identify the shared memory segment
	key := 0xff3

	// Create the shared memory segment with a size of 4096 bytes
	shmid, err := shm.Get(key, 1024, 0444|shm.IPC_CREAT)
	if err != nil {
		fmt.Println("Error creating shared memory segment:", err)
		os.Exit(1)
	}

	// Attach to the shared memory segment
	data, err := shm.At(shmid, 0, shm.SHM_RDONLY)
	if err != nil {
		fmt.Println("Error attaching to shared memory segment:", err)
		os.Exit(1)
	}

	fmt.Println("Read from shared memory:")
	idx := bytes.IndexByte(data, 0)
	if idx > -1 {
		fmt.Println(string(data[0:idx]))
	} else {
		fmt.Println("Looks like no data in shared memory")
	}

	// Detach from the shared memory segment
	err = shm.Dt(data)
	if err != nil {
		fmt.Println("Error detaching from shared memory segment:", err)
		os.Exit(1)
	}
}
